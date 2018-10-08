<?php
namespace Fixpunkt\FpMasterquiz\Controller;

/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt werbeagentur gmbh
 *
 ***/

/**
 * QuizController
 */
class QuizController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * quizRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\QuizRepository
     * @inject
     */
    protected $quizRepository = null;

    /**
     * answerRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\AnswerRepository
     * @inject
     */
    protected $answerRepository = null;

    /**
     * participantRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository
     * @inject
     */
    protected $participantRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $quizzes = $this->quizRepository->findAll();
        $this->view->assign('quizzes', $quizzes);
    }

    /**
     * action default
     *
     * @return void
     */
    public function defaultAction()
    {
    	$defaultQuizUid = $this->settings['defaultQuizUid'];
    	if (!$defaultQuizUid) {
    		$this->forward('list');
    	} else {
    		$quiz = $this->quizRepository->findOneByUid(intval($this->settings['defaultQuizUid']));
    		$this->forward('show', NULL, NULL, array('quiz' => $quiz));
    	}
    }
    
    /**
     * action show
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function showAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
        $saveIt = FALSE;
        $newUser = FALSE;
        $pages = 0;
        $questions = 0;
        $maximum1 = 0;
        $finalContent = '';
        $uidOfCE = $this->configurationManager->getContentObject()->data['uid'];
        $questionsPerPage = intval($this->settings['pagebrowser']['itemsPerPage']);
        $page = $this->request->hasArgument('@widget_0') ? $this->request->getArgument('@widget_0') : 1;
        $showAnswers = $this->request->hasArgument('showAnswers') ? intval($this->request->getArgument('showAnswers')) : 0;
        if ($this->request->hasArgument('participant') && $this->request->getArgument('participant')) {
            $participantUid = intval($this->request->getArgument('participant'));
            $participant = $this->participantRepository->findByUid($participantUid);
        } else {
            $participant = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Fixpunkt\\FpMasterquiz\\Domain\\Model\\Participant');
        }
        if (is_array($page)) {
            $page = intval($page['currentPage']);
        }
        if (!$questionsPerPage) {
        	$questionsPerPage = 1;
        }
        $showAnswerPage = intval($this->settings['showAnswerPage']);
        if ($showAnswerPage && !$showAnswers) {
            // als nächstes erstmal die Antworten dieser Seite zeigen
            $nextPage = $page;
        } else {
            $nextPage = $page + 1;
        }
        if ($showAnswers || !$showAnswerPage && $page > 1) {
            // Antworten sollen ausgewertet und gespeichert werden
            $saveIt = TRUE;
            $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
            if (!$participant->getUid()) {
                $participant->setName('default');
                $participant->setIp($this->getRealIpAddr());
                $participant->setQuiz($quiz);
                $participant->setMaximum2($quiz->getMaximum2());
                $this->participantRepository->add($participant);
                $persistenceManager->persistAll();
                $newUser = TRUE;
            }
        }
        foreach ($quiz->getQuestions() as $question) {
            $questions++;
            $quid = $question->getUid();
            if ($saveIt && $this->request->hasArgument('quest_' . $quid) && $this->request->getArgument('quest_' . $quid)) {
                // Auswertung der abgesendeten Fragen
                $qmode = $question->getQmode();
                $selected = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Fixpunkt\\FpMasterquiz\\Domain\\Model\\Selected');
                $selected->setQuestion($question);
                switch ($qmode) {
                    case 0:    foreach ($question->getAnswers() as $answer) {
                            $auid = $answer->getUid();
                            $newPoints = 0;
                            if ($this->request->hasArgument('answer_' . $quid . '_' . $auid) && $this->request->getArgument('answer_' . $quid . '_' . $auid)) {
                                $selectedAnswerUid = intval($this->request->getArgument('answer_' . $quid . '_' . $auid));
                                $selectedAnswer = $this->answerRepository->findByUid($selectedAnswerUid);
                                $selected->addAnswer($selectedAnswer);
                                $newPoints += $selectedAnswer->getPoints();
                                $selected->setPoints($newPoints);
                            }
                            if ($newPoints != 0) {
                                $participant->addPoints($newPoints);
                            }
                            $maximum1 += $answer->getPoints();
                        }
                        break;
                    case 1:    
                    case 2:    if ($this->request->hasArgument('answer_' . $quid) && $this->request->getArgument('answer_' . $quid)) {
                            $selectedAnswerUid = intval($this->request->getArgument('answer_' . $quid));
                            $selectedAnswer = $this->answerRepository->findByUid($selectedAnswerUid);
                            $selected->addAnswer($selectedAnswer);
                            $newPoints = $selectedAnswer->getPoints();
                            $selected->setPoints($newPoints);
                            if ($newPoints != 0) {
                                $participant->addPoints($newPoints);
                            }
                        }
                        $maximum1 += $question->getMaximum1();
                        break;
                }
                $participant->addSelection($selected);
            }
        }
        if ($saveIt) {
            // Update the participant result
            if ($maximum1 > 0) {
                $participant->addMaximum1($maximum1);
            }
            $this->participantRepository->update($participant);
            $persistenceManager->persistAll();
        }
        $pages = intval(ceil($questions / $questionsPerPage));
        $showAnswersNext = 0;
        if ($page > $pages) {
            // finale Auswertung ...
            $final = 1;
            foreach ($quiz->getEvaluations() as $evaluation) {
            	if (!$evaluation->isEvaluate()) {
            		// Punkte auswerten
            		$final_points = $participant->getPoints();
            	} else {
            		// Prozente auswerten
            		$final_points = $participant->getPercent2();
            	}
            	if (($final_points >= $evaluation->getMinimum()) && ($final_points <= $evaluation->getMaximum())) {
            		// Punkte-Match
            		if ($evaluation->getPage() > 0) {
            			// Weiterleitung zu diese Seite
            			$this->redirectToURI(
            					$this->uriBuilder->reset()
            					->setTargetPageUid($evaluation->getPage())
            					->build()
            			);
            		} else if ($evaluation->getCe() > 0) {
            			// Content-Element ausgeben
            			// oder so: https://www.andrerinas.de/tutorials/typo3-viewhelper-zum-rendern-von-tt-content-anhand-der-uid.html
            			$ttContentConfig = array(
            					'tables'       => 'tt_content',
            					'source'       => $evaluation->getCe(),
            					'dontCheckPid' => 1);
            			$finalContent = $this->objectManager->get('TYPO3\CMS\Frontend\ContentObject\RecordsContentObject')->render($ttContentConfig);
            		}
            	}
            }
        } else {
            $final = 0;
            // toggle mode for show answers after submit questions
            if ($showAnswerPage) {
                $showAnswersNext = $showAnswers == 1 ? 0 : 1;
            }
        }
        $this->view->assign('quiz', $quiz);
        $this->view->assign('participant', $participant);
        $this->view->assign('page', $page);
        if ($pages > 0) {
        	$this->view->assign('pagePercent', intval(round(100*($page/$pages))));
        	$this->view->assign('pagePercentInclFinalPage', intval(round(100*($page/($pages+1)))));
        }
        $this->view->assign('nextPage', $nextPage);
        $this->view->assign('pages', $pages);
        $this->view->assign('pagesInclFinalPage', ($pages+1));
        $this->view->assign('questions', $questions);
        $this->view->assign('final', $final);
        $this->view->assign('finalContent', $finalContent);
        $this->view->assign('showAnswers', $showAnswers);
        $this->view->assign('showAnswersNext', $showAnswersNext);
        $this->view->assign('uidOfCE', $uidOfCE);
    }

    /**
     * Get the real IP address
     *
     * @return 	string	IP address
     */
    function getRealIpAddr()
    {
        if (!$this->settings['user']['ipSave']) {
            $ip = '0.0.0.1';
        } elseif ($this->settings['user']['ipSave'] == 2) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if ($this->settings['user']['ipSave'] && $this->settings['user']['ipAnonymous']) {
        	$pos = strrpos($ip, '.');
        	$ip = substr($ip, 0, $pos) . '0';
        }
        return filter_var($ip, FILTER_VALIDATE_IP);
    }
}
