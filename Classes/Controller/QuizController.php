<?php
namespace Fixpunkt\FpMasterquiz\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;

/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt werbeagentur gmbh
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
     */
    protected $quizRepository = null;

    /**
     * answerRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\AnswerRepository
     */
    protected $answerRepository = null;

    /**
     * participantRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository
     */
    protected $participantRepository = null;
    
    /**
     * selectedRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\SelectedRepository
     */
    protected $selectedRepository = null;
    
    /**
     * participant
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Participant
     */
    protected $participant = null;
    
    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * Injects the quiz-Repository
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Repository\QuizRepository $quizRepository
     */
    public function injectQuizRepository(\Fixpunkt\FpMasterquiz\Domain\Repository\QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    /**
     * Injects the answer-Repository
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Repository\AnswerRepository $answerRepository
     */
    public function injectAnswerRepository(\Fixpunkt\FpMasterquiz\Domain\Repository\AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * Injects the selected-Repository
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Repository\SelectedRepository $selectedRepository
     */
    public function injectSelectedRepository(\Fixpunkt\FpMasterquiz\Domain\Repository\SelectedRepository $selectedRepository)
    {
        $this->selectedRepository = $selectedRepository;
    }

    /**
     * Injects the participant-Repository
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository $participantRepository
     */
    public function injectParticipantRepository(\Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    /**
     * Injects the Configuration Manager and is initializing the framework settings: wird doppelt aufgerufen!
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager Instance of the Configuration Manager
     */
    public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager)
    {
            $this->configurationManager = $configurationManager;
            /* Alternative:
                \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'fp_masterquiz', 'fpmasterquiz_pi1'
            */
            $tsSettings = $this->configurationManager->getConfiguration(
                \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
            );
            $tsSettings = $tsSettings['plugin.']['tx_fpmasterquiz.']['settings.'];
            $originalSettings = $this->configurationManager->getConfiguration(
                \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
            );
            // if flexform setting is empty and value is available in TS
            $overrideFlexformFields = GeneralUtility::trimExplode(',', $tsSettings['overrideFlexformSettingsIfEmpty'], true);
            foreach ($overrideFlexformFields as $fieldName) {
                if (strpos($fieldName, '.') !== false) {
                    // Multilevel
                    $keyAsArray = explode('.', $fieldName);
                    if (!($originalSettings[$keyAsArray[0]][$keyAsArray[1]]) && isset($tsSettings[$keyAsArray[0] . '.'][$keyAsArray[1]])) {
                        $originalSettings[$keyAsArray[0]][$keyAsArray[1]] = $tsSettings[$keyAsArray[0] . '.'][$keyAsArray[1]];
                    }
                } else {
                    // Simple
                    if (!($originalSettings[$fieldName]) && isset($tsSettings[$fieldName])) {
                        $originalSettings[$fieldName] = $tsSettings[$fieldName];
                    }
                }
            }
            $this->settings = $originalSettings;
    }

    /**
     * initialize action highscore
     * @return void
     */
    public function initializeHighscoreAction()
    {
        if ($this->request->hasArgument('quiz')){
            return;
        }
        $defaultQuizUid = $this->settings['defaultQuizUid'];
        if ($defaultQuizUid) {
            if ($quiz = $this->quizRepository->findOneByUid(intval($defaultQuizUid))) {
                $this->request->setArgument('quiz',$quiz);
                return;
            }
        }
        $this->addFlashMessage(
            LocalizationUtility::translate('error.quizNotFound', 'fp_masterquiz') . ' ' . intval($defaultQuizUid),
            LocalizationUtility::translate('error.error', 'fp_masterquiz'),
            \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
            false
        );
        $this->forward('list');
    }

    /**
     * initialize action showByTag
     * @return void
     */
    public function initializeShowByTagAction()
    {
        if ($this->request->hasArgument('quiz')){
            return;
        }
        $defaultQuizUid = $this->settings['defaultQuizUid'];
        if ($defaultQuizUid) {
            if ($quiz = $this->quizRepository->findOneByUid(intval($defaultQuizUid))) {
                $this->request->setArgument('quiz',$quiz);
                return;
            }
        }
        $this->addFlashMessage(
            LocalizationUtility::translate('error.quizNotFound', 'fp_masterquiz') . ' ' . intval($defaultQuizUid),
            LocalizationUtility::translate('error.error', 'fp_masterquiz'),
            \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
            false
        );
        $this->forward('list');
    }

    /**
     * action doAll
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @param int $pages No. of pages if tags are used
     * @return array
     */
    public function doAll(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz, $pages): array
    {
    	$saveIt = false;
    	$newUser = false;
    	$reload = false;
    	$doPersist = false;
    	$partBySes = null;
    	$maximum1 = 0;          // maximum points
    	$session = '';          // session key
    	$finalBodytext = '';	// bodytext and image for the final page
    	$finalImageuid = 0;     // image for the final page
    	$finalContent = '';		// special content for the final page
    	$emailAnswers = [];		// special admin email to answer relations
    	$specialRecievers = [];	// special admin email recievers
    	$debug = '';			// debug output
    	$quizUid = $quiz->getUid();
    	$questionsPerPage = intval($this->settings['pagebrowser']['itemsPerPage']);
    	$showAnswers = $this->request->hasArgument('showAnswers') ? intval($this->request->getArgument('showAnswers')) : 0;
    	$useJoker = $this->request->hasArgument('useJoker') ? intval($this->request->getArgument('useJoker')) : 0;
        $startTime = $this->request->hasArgument('startTime') ? intval($this->request->getArgument('startTime')) : 0;
    	$context = GeneralUtility::makeInstance(Context::class);
    	$fe_user_uid = intval($context->getPropertyFromAspect('frontend.user', 'id'));
   		$persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');

   		if (!$this->settings['ajax']) {
            if ($this->request->hasArgument('session')) {
                $session = $this->request->getArgument('session');
            } else if (!$this->request->hasArgument('participant')) {
                // keine Session gefunden... und jetzt Cookie checken?
                if (intval($this->settings['user']['useCookie']) == -1) {
                    $session = $GLOBALS["TSFE"]->fe_user->getKey('ses', 'qsession' . $quizUid);
                } else if ((intval($this->settings['user']['useCookie']) > 0) && isset($_COOKIE['qsession' . $quizUid])) {
                    $session = $_COOKIE['qsession' . $quizUid];
                }
                if ($session) {
                    $this->participant = $this->participantRepository->findOneBySession($session);
                    if ($this->settings['debug']) {
                        if ($this->participant) {
                            $debug .= "\nsession from cookie: " . $session . '; and the participant-uid of that session: ' . $this->participant->getUid();
                        } else {
                            $debug .= "\nsession from cookie: " . $session . '; but participant NOT FOUND!';
                        }
                    }
                } else {
                    if ($this->settings['user']['checkFEuser'] && $fe_user_uid) {
                        $this->participant = $this->participantRepository->findOneByUserAndQuiz($fe_user_uid, $quizUid);
                        if ($this->participant) {
                            $session = $this->participant->getSession();
                            if ($this->settings['debug']) {
                                $debug .= "\nsession from FEuser: " . $session . '; and the participant-uid: ' . $this->participant->getUid();
                            }
                        }
                    }
                    if (!$session) {
                        $session = uniqid(random_int(1000, 9999));
                        $newUser = true;
                        $this->participant = null;
                        if ($this->settings['debug']) {
                            $debug .= "\ncreating new session: " . $session;
                        }
                    }
                }
            }
            if (intval($this->settings['user']['useCookie']) == -1) {
                // Store the session in a cookie
                $GLOBALS['TSFE']->fe_user->setKey('ses', 'qsession' . $quizUid, $session);
                $GLOBALS["TSFE"]->fe_user->storeSessionData();
            } else if (intval($this->settings['user']['useCookie']) > 0) {
                setcookie('qsession' . $quizUid, $session, time() + (3600 * 24 * intval($this->settings['user']['useCookie'])));  /* verfällt in x Tagen */
            }
        }

    	if ($this->request->hasArgument('participant') && $this->request->getArgument('participant')) {
    		// wir sind nicht auf Seite 1
    		$participantUid = intval($this->request->getArgument('participant'));
    		$this->participant = $this->participantRepository->findOneByUid($participantUid);
    		$session = $this->participant->getSession();
    		if ($this->settings['debug']) {
    			$debug .= "\nparticipant from request: " . $participantUid;
    		}
    	} else {
    		if (!$this->participant) {
    			$this->participant = GeneralUtility::makeInstance('Fixpunkt\\FpMasterquiz\\Domain\\Model\\Participant');
    			if ($this->settings['debug']) {
    				$debug .= "\nmaking new participant.";
    			}
    		}
    	}
    	//$page = $this->request->hasArgument('@widget_0') ? $this->request->getArgument('@widget_0') : 1;
    	//if (is_array($page)) {
    	//	$page = intval($page['currentPage']);
    	//} else {
    	$page = $this->request->hasArgument('currentPage') ? intval($this->request->getArgument('currentPage')) : 1;
    	//}
    	$reachedPage = $this->participant->getPage();
    	if ($reachedPage >= $page) {
    		// beantwortete Seiten soll man nicht nochmal beantworten können
    		$showAnswers = true;
    	}
    	if (!$questionsPerPage) {
    		$questionsPerPage = 1;
    	}
    	$showAnswerPage = intval($this->settings['showAnswerPage']);
    	if ($showAnswerPage && !$showAnswers) {
    		// als Nächstes erstmal die Antworten dieser Seite zeigen
    		$nextPage = $page;
    	} else {
    		$nextPage = $page + 1;
    	}
    	if ($showAnswers) {
    		$lastPage = $page;
    	} else {
    		$lastPage = $page -1;
    	}
    	$questions = count($quiz->getQuestions());
    	if ($showAnswers || (!$showAnswerPage && $page > 1)) {
    		// Antworten sollen ausgewertet und gespeichert werden
    		if ($reachedPage < $page) {
    			// nur nicht beantwortete Seiten speichern
    			$saveIt = true;
    		}
    		if (!$this->participant->getUid()) {
    			if (!$newUser && $session) {
    				$partBySes = $this->participantRepository->findOneBySession($session);
    			}
    			if ($partBySes) {
    				$this->participant = $partBySes;
    				$reload = true;
    				if ($this->settings['debug']) {
    					$debug .= "\nReload nach absenden von Seite 1 detektiert.";
    				}
    			} else {
    				if ($this->settings['user']['checkFEuser'] && $fe_user_uid) {
    					$feuserData = $this->getFeUser($fe_user_uid);
    					$defaultName = $feuserData['name'];
    					$defaultEmail = $feuserData['email'];
    					$defaultHomepage = $feuserData['www'];
    				} else {
		    			$defaultName = $this->settings['user']['defaultName'];
		    			$defaultName = str_replace('{TIME}', date('Y-m-d H:i:s'), $defaultName);
		    			$defaultEmail = $this->settings['user']['defaultEmail'];
		    			$defaultHomepage = $this->settings['user']['defaultHomepage'];
    				}
	    			if ($this->settings['user']['askForData']) {
	    			    if ($this->request->hasArgument('name') && $this->request->getArgument('name')) {
	    			        $defaultName = $this->request->getArgument('name');
	        			}
	        			if ($this->request->hasArgument('email') && $this->request->getArgument('email')) {
	        			    $defaultEmail = $this->request->getArgument('email');
	        			}
	        			if ($this->request->hasArgument('homepage') && $this->request->getArgument('homepage')) {
	        			    $defaultHomepage = $this->request->getArgument('homepage');
	        			}
	    			}
	    			$this->participant->setName($defaultName);
	    			$this->participant->setEmail($defaultEmail);
	    			$this->participant->setHomepage($defaultHomepage);
	    			$this->participant->setUser(intval($GLOBALS['TSFE']->fe_user->user['uid']));
	    			$this->participant->setIp($this->getRealIpAddr());
	    			$this->participant->setSession($session);
                    if ($startTime) {
                        $this->participant->setSessionstart(time() - $startTime);
                    }
	    			$this->participant->setQuiz($quiz);
	    			$this->participant->setMaximum2($quiz->getMaximum2());
	    			$this->participantRepository->add($this->participant);
	    			$persistenceManager->persistAll();
	    			$newUser = true;
	    			if ($this->settings['debug']) {
	    				$debug .= "\nNew participant created: " . $this->participant->getUid();
    				}
    			}
    		}
    	}
    	$completed = $this->participant->isCompleted();
    	
    	// Ausgewählte Antworten auswerten und speichern
    	if ($saveIt && !$reload && !$completed && ($useJoker != 1)) {
    		// special preparation
    		if ($this->settings['email']['sendToAdmin'] && $this->settings['email']['specific']) {
   				$emailAnswers = json_decode($this->settings['email']['specific'], true);
   				//var_dump($emailAnswers);
    		}
    		$i = 0;
    		// cycle through all questions after a submit
    		foreach ($quiz->getQuestions() as $question) {
    			$quid = $question->getUid();
    			$debug .= "\n#" . $quid . '#: ';
    			if ($this->request->hasArgument('quest_' . $quid) && $this->request->getArgument('quest_' . $quid)) {
    				$isActive = true;
    			} else if ($_POST['quest_' . $quid] || $_GET['quest_' . $quid]) {
    				// Ajax-call is without extensionname :-(
    				$isActive = true;
    			} else {
    				$isActive = false;
    			}
    			if ($isActive) {	
    				// Auswertung der abgesendeten Fragen
    				if (!$newUser) {
    					// zuerst prüfen, ob dieser Eintrag schon existiert (z.B. durch Reload)
    					$vorhanden = $this->selectedRepository->countByParticipantAndQuestion($this->participant->getUid(), $quid);
    				}
    				if ($vorhanden > 0) {
    					$debug .= ' reload! ';
    				} else {
	    				$debug .= ' OK ';
	    				// selected/answered question
	    				$selected = GeneralUtility::makeInstance('Fixpunkt\\FpMasterquiz\\Domain\\Model\\Selected');
	    				$selected->setQuestion($question);
	    				if ($pages) {
	    				    // bei Verwendung von Tags kann die Reihenfolge nicht mit der Reihenfolge der Fragen übereinstimmen
	    				    $sorting = $page*100 + $i;
                        } else {
	    				    // Reihenfolge der Fragen übernehmen
	    				    $sorting = $question->getSorting();
                        }
	    				$selected->setSorting($sorting);
	    				$qmode = $question->getQmode();
	    				$newPoints = 0;
	    				switch ($qmode) {
	    					case 0:
	    					case 4:
	    					    // Checkbox und ja/nein
	    						foreach ($question->getAnswers() as $answer) {
	    							$auid = $answer->getUid();
	    							if ($this->request->hasArgument('answer_' . $quid . '_' . $auid) && $this->request->getArgument('answer_' . $quid . '_' . $auid)) {
	    								$selectedAnswerUid = intval($this->request->getArgument('answer_' . $quid . '_' . $auid));
	    							} else if ($_POST['answer_' . $quid . '_' . $auid]) {
	    								$selectedAnswerUid = intval($_POST['answer_' . $quid . '_' . $auid]);
	    							} else if ($_GET['answer_' . $quid . '_' . $auid]) {
	    								$selectedAnswerUid = intval($_GET['answer_' . $quid . '_' . $auid]);
	    							} else {
	    								$selectedAnswerUid = -1;
	    							}
	    							if ($this->settings['debug']) {
	    								$debug .= $quid . '_' . $auid . '-' . $selectedAnswerUid . ' ';
	    							}
	    							if ($selectedAnswerUid > 0) {
	    								$selectedAnswer = $this->answerRepository->findByUid($selectedAnswerUid);
	    								$newPoints = $selectedAnswer->getPoints();
		    							// halbierte Punkte setzen? Ändert aber die echte Antwort!
	    								// so nicht: $selectedAnswer->setPoints($newPoints);
	    								if ($newPoints != 0) {
	    									if ($useJoker == 2) {
	    										// Joker wurde eingesetzt: Punkte halbieren
	    										$newPoints = intval(ceil($newPoints/2));
	    									}
	    									$selected->addPoints($newPoints);
	    									$this->participant->addPoints($newPoints);
	    									if ($this->settings['debug']) {
	    										$debug .= $newPoints . 'P ';
	    									}
	    								}
		    							$selected->addAnswer($selectedAnswer);
		    							if ($emailAnswers[$quid][$auid]) {
		    								$specialRecievers[$emailAnswers[$quid][$auid]['email']] = $emailAnswers[$quid][$auid];
		    							}
	    							}
	    							// statt hier nun nach der Schleife: $maximum1 += $answer->getPoints();
	    						}
	    						$maximum1 += $question->getMaximum1();
	    						break;
	    					case 1:
	    					case 2:
							case 7:
	    					    // Radio-box, Select-option und star rating
	    						if ($this->request->hasArgument('answer_' . $quid) && $this->request->getArgument('answer_' . $quid)) {
	    							$selectedAnswerUid = intval($this->request->getArgument('answer_' . $quid));
	    						} else if ($_POST['answer_' . $quid]) {
	    							$selectedAnswerUid = intval($_POST['answer_' . $quid]);
	    						} else if ($_GET['answer_' . $quid]) {
	    							$selectedAnswerUid = intval($_GET['answer_' . $quid]);
	    						} else {
	    							$selectedAnswerUid = 0;
	    						}
	    						if ($this->settings['debug']) {
	    							$debug .= $quid . '-' . $selectedAnswerUid . ' ';
	    						}
	    						if ($selectedAnswerUid) { // Alternative: && $qmode != 4) {
	    							$selectedAnswer = $this->answerRepository->findByUid($selectedAnswerUid);
	    							if ($qmode == 7) {
	    								$cycle = count($question->getAnswers());
	    								foreach ($question->getAnswers() as $answer) {
	    									if ($answer->getUid() == $selectedAnswerUid) {
	    										$newPoints = $cycle;
	    										break;
	    									}
	    									$cycle--;
	    								}
	    							} else {
	    								$newPoints = $selectedAnswer->getPoints();
	    							}
	    							// so nicht: $selectedAnswer->setPoints($newPoints);
	    							if ($newPoints != 0) {
	    								if ($useJoker == 2) {
	    									// Joker wurde eingesetzt: Punkte halbieren
	    									$newPoints = intval(ceil($newPoints/2));
	    								}
	    								$selected->addPoints($newPoints);
	    								$this->participant->addPoints($newPoints);
	    								if ($this->settings['debug']) {
	    									$debug .= $newPoints . 'P ';
	    								}
	    							}
	    							$selected->addAnswer($selectedAnswer);
	    							if ($emailAnswers[$quid][$selectedAnswerUid]) {
	    								$specialRecievers[$emailAnswers[$quid][$selectedAnswerUid]['email']] = $emailAnswers[$quid][$selectedAnswerUid];
	    							}
	    						}
	    						$maximum1 += $question->getMaximum1();
	    						break;
                            case 3:
                            case 5:
                                // When enter an answer in a textbox: try to evaluate the answer of the textbox
	    					    $this->evaluateInputTextAnswerResult($quid, $question, $selected, $debug, $maximum1);
	    					    break;
                            default:
                                // hier passiert nichts
	    				}
	    				// assign the selected dataset to the participant
	    				$this->participant->addSelection($selected);
    				}
    			}
    			$i++;
    		}
    		// Update the participant result
    		if ($maximum1 > 0) {
    			$this->participant->addMaximum1($maximum1);
    		}
    		$this->participant->setPage($lastPage);
    		$this->participantRepository->update($this->participant);
    		$doPersist = true;
    	}
    	if (!$pages) {
            $pages = intval(ceil($questions / $questionsPerPage));
        }
    	if ($this->settings['debug']) {
    		$debug .= "\nlast page: ".$lastPage.'; page: '.$page.'; reached page before: '.$reachedPage.'; next page: '.$nextPage.'; showAnswers: '.$showAnswers;
    		$debug .= "\nqs/qpp=pages#" . $questions . '/' . $questionsPerPage . '=' . $pages;
            $debug .= "\ntime period=" . $quiz->getTimeperiod() . '; time passed: ' . $this->participant->getTimePassed();
    	}

        // toggle mode for show answers after submit questions
        if ($showAnswerPage) {
            $showAnswersNext = $showAnswers == 1 ? 0 : 1;
        } else {
            $showAnswersNext = 0;
        }

        if (!$showAnswers && $quiz->getTimeperiod() && ($this->participant->getTimePassed() >= $quiz->getTimeperiod())) {
            // Die Zeit für ein Quiz ist abgelaufen: auf zur finalen Seite
            $page = $pages + 1;
            $nextPage = $page;
        }

    	if ($page > $pages) {
    		// finale Auswertung ...
    		$final = 1;
            $showAnswersNext = 0;
    		foreach ($quiz->getEvaluations() as $evaluation) {
    			if (!$evaluation->isEvaluate()) {
    				// Punkte auswerten
    				$final_points = $this->participant->getPoints();
    			} else {
    				// Prozente auswerten
    				$final_points = $this->participant->getPercent2();
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
    					$ttContentConfig = [
    							'tables'       => 'tt_content',
    							'source'       => $evaluation->getCe(),
    							'dontCheckPid' => 1
                        ];
    					$finalContent = $this->objectManager->get('TYPO3\CMS\Frontend\ContentObject\RecordsContentObject')->render($ttContentConfig);
    					$finalBodytext = $evaluation->getBodytext();
    					$finalImageuid = $evaluation->getImage();
    				} else {
    					$finalBodytext = $evaluation->getBodytext();
    					$finalImageuid = $evaluation->getImage();
    				}
    				if ($finalImageuid) {
    					$finalImageuid = $finalImageuid->getUid();
    				}
    			}
    		}
    		// Alle Ergebnisse nicht nur das eigene anzeigen
    		if ($this->settings['showAllAnswers'] == 1) {
    		    // alle Fragen durchgehen, die der User beantwortet hat:
    		    foreach ($this->participant->getSortedSelections() as $selection) {
    		        $oneQuestion = $selection->getQuestion();
                    $debug .= $this->setAllUserAnswersForOneQuestion($oneQuestion, 0,false);
                    // eigene Ergebnisse durchgehen
                    $ownResults = [];
                    foreach ($selection->getAnswers() as $oneAnswer) {
                        if ($this->settings['debug']) {
                            $debug .= "\n own:" . $oneAnswer->getTitle() . ': ' . $oneAnswer->getPoints() . "P";
                        }
                        $ownResults[$oneAnswer->getUid()]++;
                    }
                    foreach ($oneQuestion->getAnswers() as $oneAnswer) {
                        $oneAnswer->setOwnAnswer (intval($ownResults[$oneAnswer->getUid()]));
                    }
    		    }
    		}
    		if (!$completed && ($this->settings['email']['sendToAdmin'] || $this->settings['email']['sendToUser'])) {
    			// GGf. Emails versenden
				$dataArray = [
				    'uid' => $this->participant->getUid(),
				    'email' => $this->participant->getEmail(),
				    'name' => $this->participant->getName(),
				    'homepage' => $this->participant->getHomepage(),
				    'participant' => $this->participant,
				    'finalContent' => $finalContent,
				    'settings' => $this->settings
				];
				if ($this->settings['email']['sendToAdmin'] && ($this->settings['email']['adminEmail'] || !empty($specialRecievers))) {
					if (GeneralUtility::validEmail($this->settings['email']['adminEmail'])) {
						$this->sendTemplateEmail(
							array($this->settings['email']['adminEmail'] => $this->settings['email']['adminName']),
							array($this->settings['email']['fromEmail'] => $this->settings['email']['fromName']),
							$this->settings['email']['adminSubject'],
							'ToAdmin',
							$dataArray,
							true
						);
						if ($this->settings['debug']) {
							$debug .= "\n sending email to: " . $this->settings['email']['adminName']
								.' <'. $this->settings['email']['adminEmail'] . '> : ' . $this->settings['email']['adminSubject'];
						}
					}
					if (!empty($specialRecievers)) {
						foreach ($specialRecievers as $email => $emailArray) {
							if (GeneralUtility::validEmail($email)) {
								$this->sendTemplateEmail(
									array($email => $emailArray['name']),
									array($this->settings['email']['fromEmail'] => $this->settings['email']['fromName']),
									$emailArray['subject'],
									'ToAdmin',
									$dataArray,
									true
								);
								if ($this->settings['debug']) {
									$debug .= "\n sending email to: " . $emailArray['name']	.' <'.  $email . '> : ' . $emailArray['subject'];
								}
							}
						}
					}
				}
				if ($this->settings['email']['sendToUser'] && GeneralUtility::validEmail($dataArray['email'])) {
					$this->sendTemplateEmail(
						array($dataArray['email'] => $dataArray['name']),
						array($this->settings['email']['fromEmail'] => $this->settings['email']['fromName']),
						$this->settings['email']['userSubject'],
						'ToUser',
						$dataArray,
						false
					);
					if ($this->settings['debug']) {
						$debug .= "\n sending email to: " . $dataArray['name'] .' <'. $dataArray['email'] . '> : ' . $this->settings['email']['userSubject'];
					}
				}
    		}
			$this->participant->setCompleted(true);
            $this->participantRepository->update($this->participant);
            $doPersist = true;
    	} else {
    		$final = 0;
    	}
    	if ($doPersist) {
    		$persistenceManager->persistAll();
        }
    	$data = [
   			'page' => $page,
   			'pages' => $pages,
            'lastPage' => $lastPage,
   			'nextPage' => $nextPage,
   			'questions' => $questions,
   			'final' => $final,
   			'finalContent' => $finalContent,
    		'finalBodytext' => $finalBodytext,
    		'finalImageuid' => $finalImageuid,
   			'showAnswers' => $showAnswers,
    	    'showAnswersNext' => $showAnswersNext,
    	    'useJoker' => $useJoker,
    		'session' => $session,
   			'debug' => $debug
    	];
    	return $data;
    }
    
    /**
     * Try to evaluate the answer of an Input Textbox 
     * 
     * @param int $i_quid The Question ID
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Question $i_question The Question dataset
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Selected $c_selected The Selected dataset
     * @param string $c_debug Debug
     * @param int $c_maximum1 The max. possible points until the current question
     */
    protected function evaluateInputTextAnswerResult(int $i_quid, 
                                                   \Fixpunkt\FpMasterquiz\Domain\Model\Question $i_question, 
                                                   \Fixpunkt\FpMasterquiz\Domain\Model\Selected &$c_selected,
                                                   string &$c_debug,
                                                   int &$c_maximum1)
    {
        // retreive answer over the GET arguments
        if ($this->request->hasArgument('answer_text_' . $i_quid) && $this->request->getArgument('answer_text_' . $i_quid)) {
            $answerText = $this->request->getArgument('answer_text_' . $i_quid);
            $c_debug .= "\n" . $i_quid . '- Answer in the Inputbox is: ' . $answerText . ' ';
            
        // retreive answer over the POST arguments
        } else if ($_POST['answer_text_' . $i_quid]) {
            $answerText = $_POST['answer_text_' . $i_quid];
            $c_debug .= "\n" . $i_quid . '- Answer in the Inputbox is: ' . $answerText . ' ';
            
        // retreive answer over the GET arguments
        } else if ($_GET['answer_text_' . $i_quid]) {
        	$answerText = $_GET['answer_text_' . $i_quid];
        	$c_debug .= "\n" . $i_quid . '- Answer in the Inputbox is: ' . $answerText . ' ';
        
        // if evereything fails
        } else {
            /* @todo Error handling */
            $answerText = "";
        }
        
        // for security reasons check the input from the frontend
        $answerText = filter_var($answerText, FILTER_SANITIZE_STRING);
        
        // store the answer of the participant in the selected dataset
        $c_selected->setEntered($answerText);
        
        foreach ($i_question->getAnswers() as $answer) {
            // store the correct answer in the selected dataset
            $c_selected->addAnswer($answer);
            
            if ($i_question->getQmode() == 3) {
	            // sum the the points of the current answer to the max. possible point until the current question
	            $c_maximum1 += $answer->getPoints();
	            
	            // if the answer is right
	            if (strtoupper(trim($answer->getTitle())) == strtoupper(trim($answerText))) {
	                $newPoints = $answer->getPoints();
	                if ($newPoints != 0) {
	                    $c_selected->addPoints($newPoints);
	                    $this->participant->addPoints($newPoints);
	                    $c_debug .= "\n" . '+' .$newPoints . 'P ';
	                }
	            }
	        }
        }
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
    		$ip = substr($ip, 0, $pos) . '.0';
    	}
    	return filter_var($ip, FILTER_VALIDATE_IP);
    }
    
    /**
     * action getFeUser
     *
     * @param int $userid
     * @return array
     */
    public function getFeUser($userid)
    {
    	$connection = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getConnectionForTable('fe_users');
    	$queryBuilder = $connection->createQueryBuilder();
    	$statement = $queryBuilder->select('*')->from('fe_users')->where(
    		$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($userid, \PDO::PARAM_INT))
    	)->setMaxResults(1)->execute();
    	while ($row = $statement->fetch()) {
    		return $row;
    	}
    }

    /**
     * Set all user-answers to a question
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Question $oneQuestion The question dataset
     * @param int $pid
     * @param boolean $be
     * @return string
     */
    protected function setAllUserAnswersForOneQuestion(\Fixpunkt\FpMasterquiz\Domain\Model\Question &$oneQuestion, int $pid, bool $be)
    {
        $votes = 0;
        $votesTotal = 0;
        $debug = '';
        $allResults = [];
        $questionID = $oneQuestion->getUid();
        $isEnterQuestion = (($oneQuestion->getQmode() == 3) || ($oneQuestion->getQmode() == 5));
        if ($this->settings['debug']) {
            $debug .= "\nquestion :" . $questionID;
        }
        if ($be) {
            $allAnsweredQuestions = $this->selectedRepository->findFromPidAndQuestion($pid, $questionID);
        } else {
            $allAnsweredQuestions = $this->selectedRepository->findByQuestion($questionID);
        }
        // alle User-Ergebnisse durchgehen:
        foreach ($allAnsweredQuestions as $aSelectedQuestion) {
            $votes++;
            // alle Antworten auf diese Frage:
            foreach ($aSelectedQuestion->getAnswers() as $oneAnswer) {
                if ($this->settings['debug']) {
                    $debug .= "\n all: " . $oneAnswer->getTitle() . ': ' . $oneAnswer->getPoints() . "P";
                }
                if (($isEnterQuestion && ($aSelectedQuestion->getEntered() == $oneAnswer->getTitle())) || !$isEnterQuestion) {
                    $allResults[$oneAnswer->getUid()]++;
                } else if ($be) {
                    // Text-Antworten anderer interessieren uns nur im Backend
                    if (!is_array($allResults['text'])) {
                        $allResults['text'] = [];
                    }
                    if (!is_array($allResults['text'][$aSelectedQuestion->getEntered()])) {
                        $allResults['text'][$aSelectedQuestion->getEntered()] = [];
                    }
                    $allResults['text'][$aSelectedQuestion->getEntered()]['sum']++;
                }
            }
        }
        // gesammeltes speichern bei: alle möglichen Antworten einer Frage und Prozentwerte setzen
        foreach ($oneQuestion->getAnswers() as $oneAnswer) {
            $thisVotes = intval($allResults[$oneAnswer->getUid()]);
            $votesTotal += $thisVotes;
            if ($be && $isEnterQuestion && is_array($allResults) && is_array($allResults['text'])) {
                // bei Text-Antworten alle Textantworten berücksichtigen
                foreach ($allResults['text'] as $otherKey => $otherValue) {
                    $votesTotal += $otherValue['sum'];
                    $allResults['text'][$otherKey]['percent'] = number_format(100 * ($otherValue['sum'] / $votes), 2, '.', '');
                }
                $oneQuestion->setTextAnswers($allResults['text']);
            }
            $oneAnswer->setAllAnswers($thisVotes);
        }
        foreach ($oneQuestion->getAnswers() as $oneAnswer) {
            $thisVotes = intval($allResults[$oneAnswer->getUid()]);
            $percentage = 0;
            if ($votes) {
                $percentage = 100 * ($thisVotes / $votes);
            }
            $oneAnswer->setAllPercent( $percentage );
            $percentage = 0;
            if ($votesTotal) {
                $percentage = 100 * ($thisVotes / $votesTotal);
            }
            if ($this->settings['debug']) {
                $debug .= "\n percent: 100*" . $thisVotes . '/' . $votes . ' = ' . 100 * ($thisVotes / $votes);
                $debug .= "\n total percent: 100*" . $thisVotes . '/' . $votesTotal . ' = ' . $percentage;
            }
            $oneAnswer->setTotalPercent( $percentage );
        }
        $oneQuestion->setAllAnswers($votes);
        $oneQuestion->setTotalAnswers($votesTotal);
    }

    /**
     * Set all user-answers to a quiz
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $c_quiz The Quiz dataset
     * @param int $pid
     * @param boolean $be
     * @return string
     */
    protected function setAllUserAnswers(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz &$c_quiz, int $pid, bool $be)
    {
    	$debug = '';
    	// Alternative: $selectedRepository = $this->objectManager->get('Fixpunkt\\FpMasterquiz\\Domain\\Repository\\SelectedRepository');
    	foreach ($c_quiz->getQuestions() as $oneQuestion) {
    		$debug .= $this->setAllUserAnswersForOneQuestion($oneQuestion, $pid, $be);
    	}
    	return $debug;
    }

    /**
     * Set all metatags
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $c_quiz The Quiz dataset
     * @return void
     */
    protected function setMetatags(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz &$c_quiz)
    {
        $title = $c_quiz->getName();
        $GLOBALS['TSFE']->page['title'] = $title;
        $metaTagManager = GeneralUtility::makeInstance( \TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry::class);
        $description = str_replace(array("\r", "\n"), " ", $c_quiz->getAbout());
        $description = str_replace("  ", " ", $description);
        $meta = $metaTagManager->getManagerForProperty('description');
        $meta->addProperty('description', $description);
        $meta = $metaTagManager->getManagerForProperty('og:description');
        $meta->addProperty('og:description', $description);
        $meta = $metaTagManager->getManagerForProperty('og:title');
        $meta->addProperty('og:title', $title);
    }
    
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
     * action default: ein Quiz oder alle Quizze anzeigen. Nur forward!
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
    		if ($quiz) {
    			$this->forward('show', null, null, array('quiz' => $quiz->getUid()));
    		} else {
    			$this->addFlashMessage(
    				LocalizationUtility::translate('error.quizNotFound', 'fp_masterquiz') . ' ' . intval($this->settings['defaultQuizUid']),
    				LocalizationUtility::translate('error.error', 'fp_masterquiz'),
    				\TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
    				false
    			);
    			$this->forward('list');
    		}
    	}
    }
    
    /**
     * action defaultres: ein Quiz oder alle Quizze anzeigen.
     *
     * @return void
     */
    public function defaultresAction()
    {
    	$defaultQuizUid = $this->settings['defaultQuizUid'];
    	if (!$defaultQuizUid) {
    		$this->forward('list');
    	} else {
    		$quiz = $this->quizRepository->findOneByUid(intval($this->settings['defaultQuizUid']));
    		if ($quiz) {
    			$this->forward('result', null, null, array('quiz' => $quiz->getUid()));
    		} else {
    			$this->addFlashMessage(
    				LocalizationUtility::translate('error.quizNotFound', 'fp_masterquiz') . ' ' . intval($this->settings['defaultQuizUid']),
    				LocalizationUtility::translate('error.error', 'fp_masterquiz'),
    				\TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
    				false
    			);
    			$this->forward('list');
    		}
    	}
    }


    /**
     * action intro
     *
     * @return void
     */
    public function introAction()
    {
        if ($this->settings['introContentUid'] > 0) {
            $ttContentConfig = array(
                'tables'       => 'tt_content',
                'source'       => $this->settings['introContentUid'],
                'dontCheckPid' => 1);
            $contentElement = $this->objectManager->get('TYPO3\CMS\Frontend\ContentObject\RecordsContentObject')->render($ttContentConfig);
        } else {
            $contentElement = '';
        }
        $defaultQuizUid = $this->settings['defaultQuizUid'];
        if ($defaultQuizUid) {
            $quiz = $this->quizRepository->findOneByUid(intval($defaultQuizUid));
            if ($quiz) {
                $this->view->assign('quiz', $quiz);
            } else {
                $this->view->assign('quiz', 0);
                $this->addFlashMessage(
                    LocalizationUtility::translate('error.quizNotFound', 'fp_masterquiz') . ' ' . intval($defaultQuizUid),
                    LocalizationUtility::translate('error.error', 'fp_masterquiz'),
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
                    false
                );
            }
        } else {
            $this->view->assign('quiz', 0);
        }
        $this->view->assign('action', 'show');
        $this->view->assign('uidOfCE', $this->configurationManager->getContentObject()->data['uid']);
        $this->view->assign('uidOfPage', $GLOBALS['TSFE']->id);
        $this->view->assign('contentElement', $contentElement);
    }

    /**
     * action show
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function showAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
        $data = $this->doAll($quiz,0);
        $page = $data['page'];
        $pages = $data['pages'];
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        if ($this->settings['setMetatags']) {
            $this->setMetatags($quiz);
        }

        if ($quiz->getQuestions()) {
            $questionsArray = $quiz->getQuestions()->toArray();
        } else {
            $questionsArray = [];
        }
        if ($this->participant && $this->participant->getSelections()) {
            $participantArray = $this->participant->getSelections()->toArray();
        } else {
            $participantArray = [];
        }
        $quizPaginator = new ArrayPaginator($questionsArray, $page, $this->settings['pagebrowser']['itemsPerPage']);
        $participantPaginator = new ArrayPaginator($participantArray, $page, $this->settings['pagebrowser']['itemsPerPage']);

        $this->view->assign('debug', $data['debug']);
        $this->view->assign('quiz', $quiz);
        $this->view->assign('quizPaginator', $quizPaginator);
        $this->view->assign('participant', $this->participant);
        $this->view->assign('participantPaginator', $participantPaginator);
        $this->view->assign('page', $page);
        if ($pages > 0) {
        	$this->view->assign('pagePercent', intval(round(100*($page/$pages))));
        	$this->view->assign('pagePercentInclFinalPage', intval(round(100*($page/($pages+1)))));
        }        
        $this->view->assign('nextPage', $data['nextPage']);
        $this->view->assign('pages', $pages);
        $this->view->assign('pagesInclFinalPage', ($pages+1));
        $this->view->assign('questions', $data['questions']);
        $this->view->assign('pageBasis', ($page-1) * $this->settings['pagebrowser']['itemsPerPage']);
        $this->view->assign('final', $data['final']);
        $this->view->assign('finalContent', $data['finalContent']);
        $this->view->assign('finalBodytext', $data['finalBodytext']);
        $this->view->assign('finalImageuid', $data['finalImageuid']);
        $this->view->assign('session', $data['session']);
        $this->view->assign('showAnswers', $data['showAnswers']);
        $this->view->assign('showAnswersNext', $data['showAnswersNext']);
        $this->view->assign("sysLanguageUid", $sys_language_uid);
        $this->view->assign('uidOfPage', $GLOBALS['TSFE']->id);
        $this->view->assign('uidOfCE', $this->configurationManager->getContentObject()->data['uid']);
        $this->view->assign('startTime', time());
       // $this->view->assign("action", ($this->settings['ajax']) ? 'showAjax' : 'show');
        if ($this->settings['user']['askForData'] == 2) {
            if ($this->request->hasArgument('name') && $this->request->getArgument('name')) {
                $this->view->assign('name', $this->request->getArgument('name'));
            }
            if ($this->request->hasArgument('email') && $this->request->getArgument('email')) {
                $this->view->assign('email', $this->request->getArgument('email'));
            }
            if ($this->request->hasArgument('homepage') && $this->request->getArgument('homepage')) {
                $this->view->assign('homepage', $this->request->getArgument('homepage'));
            }
        }
    }

    /**
     * action showByTag
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function showByTagAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
        $page = $this->request->hasArgument('currentPage') ? intval($this->request->getArgument('currentPage')) : 1;
        // Suche Fragen passend zu einer Seite (jeweils nur 1 Tag verwendet)
        $tagArray = $quiz->getQuestionsSortByTag($page);
        $tag = $tagArray['pagetags'][$page];
        $pages = $tagArray['pages'];
        $data = $this->doAll($quiz, $pages);
        $lastPage = $data['lastPage'];
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        if ($this->settings['setMetatags']) {
            $this->setMetatags($quiz);
        }
        if ($lastPage < 1) {
            $tagSelections = [];
        } else {
            $tagSelections = $this->participant->getSelectionsByTag($tagArray['pagetags'][$lastPage]);
        }

        $this->view->assign('debug', $data['debug']);
        $this->view->assign('quiz', $quiz);
        $this->view->assign('tag', $tag);
        $this->view->assign('tagQuestions', $tagArray['questions']);
        $this->view->assign('tagSelections', $tagSelections);
        $this->view->assign('participant', $this->participant);
        $this->view->assign('page', $page);
        if ($pages > 0) {
            $this->view->assign('pagePercent', intval(round(100*($page/$pages))));
            $this->view->assign('pagePercentInclFinalPage', intval(round(100*($page/($pages+1)))));
        }
        $this->view->assign('nextPage', $data['nextPage']);
        $this->view->assign('pages', $pages);
        $this->view->assign('pagesInclFinalPage', ($pages+1));
        $this->view->assign('questions', $data['questions']);
        $this->view->assign('pageBasis', 0);
        $this->view->assign('final', $data['final']);
        $this->view->assign('finalContent', $data['finalContent']);
        $this->view->assign('finalBodytext', $data['finalBodytext']);
        $this->view->assign('finalImageuid', $data['finalImageuid']);
        $this->view->assign('session', $data['session']);
        $this->view->assign('showAnswers', $data['showAnswers']);
        $this->view->assign('showAnswersNext', $data['showAnswersNext']);
        $this->view->assign("sysLanguageUid", $sys_language_uid);
        $this->view->assign('uidOfPage', $GLOBALS['TSFE']->id);
        $this->view->assign('uidOfCE', $this->configurationManager->getContentObject()->data['uid']);
        $this->view->assign('startTime', time());
        if ($this->settings['user']['askForData'] == 2) {
            if ($this->request->hasArgument('name') && $this->request->getArgument('name')) {
                $this->view->assign('name', $this->request->getArgument('name'));
            }
            if ($this->request->hasArgument('email') && $this->request->getArgument('email')) {
                $this->view->assign('email', $this->request->getArgument('email'));
            }
            if ($this->request->hasArgument('homepage') && $this->request->getArgument('homepage')) {
                $this->view->assign('homepage', $this->request->getArgument('homepage'));
            }
        }
    }

    /**
     * action showAjax. So könnte es vielleicht auch gehen: at dontverifyrequesthash
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function showAjaxAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
    	// siehe: https://www.sebkln.de/tutorials/erstellung-einer-typo3-extension-mit-ajax-aufruf/
    //	$quizUid = $this->request->hasArgument('quiz') ? intval($this->request->getArgument('quiz')) : 0;
    //	if ($quizUid) {
    		// vorerst mal
    		$this->settings['user']['useCookie'] = 0;
    //		$quiz = $this->quizRepository->findOneByUid($quizUid);
    		$data = $this->doAll($quiz,0);
    		$page = $data['page'];
    		$pages = $data['pages'];
    		$from = 1 + (($page-1) * intval($this->settings['pagebrowser']['itemsPerPage']));
    		$to = ($page * intval($this->settings['pagebrowser']['itemsPerPage']));
    		$languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
    		$sys_language_uid = $languageAspect->getId();

    		if ($data['useJoker'] == 1) {
    		    // Joker-Antworten hier automatisch setzen
    			if ($this->settings['debug']) {
    				$data['debug'] .= "\nJoker was used. Setting automatic joker answers: ";
    			}
    		    $i=0;
    		    $jokerSet = 0;
    		    $jokerMax = 0;
    		    foreach ($quiz->getQuestions() as $question) {
    		        $i++;
    		        // uns interessiert nur die aktuelle Seite
    		        if ($i == $page) {
    		            // Schritt 1: richtige Antworten auf 0 setzen, falsche auf 1
    		        	if ($this->settings['debug']) {
    		        		$data['debug'] .= $question->getTitle() . "/";
    		        	}
    		            foreach ($question->getAnswers() as $answer) {
    		                $jokerMax++;
    		                $points = $answer->getPoints();
    		                if ($points > 0) {
    		                    $answer->setJokerAnswer(0);
    		                    $jokerSet++;
    		                } else {
    		                    $answer->setJokerAnswer(1);
    		                }
    		            }
    		            $jokerHalf = intval(ceil($jokerMax/2));   // aus 5 wird 3, aus 4 wird 2
    		            $jokerFehlend = $jokerHalf - $jokerSet;   // 3-1=2; 2-1=1 bei 1 richtigen Antwort
    		            // Schritt 2: # fehlende Joker auf 0 (richtig) setzen
    		            foreach ($question->getAnswers() as $answer) {
    		                if ($jokerFehlend && ($answer->getJokerAnswer() == 1)) {
    		                    $random = random_int($jokerSet+1, $jokerMax);     // 2 bis 5 (1/4) bzw. 2 bis 4 (1/3)
    		                    if ($random == $jokerMax) {       // Wahrscheinlichkeit 1/4 bzw. 1/3
    		                        $jokerFehlend--;
    		                        $answer->setJokerAnswer(0);
    		                        if ($this->settings['debug']) {
    		                        	$data['debug'] .= $answer->getTitle() . "#";
    		                        }
    		                    }
    		                }
    		            }
    		            // Schritt 3: falls nicht genug Antworten als pseudo-richtig ausgewählt wurden...
    		            if ($jokerFehlend) {
    		                // ...einfach die ersten Antworten auswählen
    		                foreach ($question->getAnswers() as $answer) {
    		                    if ($jokerFehlend && ($answer->getJokerAnswer() == 1)) {
   		                            $jokerFehlend--;
   		                            $answer->setJokerAnswer(0);
   		                            if ($this->settings['debug']) {
   		                            	$data['debug'] .= $answer->getTitle() . "##";
   		                            }
    		                    }
    		                }
    		            }
    		        }
    		    }
    		}
    		
    		$this->view->assign('debug', $data['debug']);
    		$this->view->assign('quiz', $quiz);
    		$this->view->assign('participant', $this->participant);
    		$this->view->assign('page', $page);
    		if ($pages > 0) {
    			$this->view->assign('pagePercent', intval(round(100*($page/$pages))));
    			$this->view->assign('pagePercentInclFinalPage', intval(round(100*($page/($pages+1)))));
    		}
    		$this->view->assign('nextPage', $data['nextPage']);
    		$this->view->assign('pages', $pages);
    		$this->view->assign('pagesInclFinalPage', ($pages+1));
    		$this->view->assign('questions', $data['questions']);
    		$this->view->assign('pageBasis', ($page-1) * $this->settings['pagebrowser']['itemsPerPage']);
    		$this->view->assign('final', $data['final']);
    		$this->view->assign('finalContent', $data['finalContent']);
    		$this->view->assign('session', $data['session']);
    		$this->view->assign('showAnswers', $data['showAnswers']);
    		$this->view->assign('showAnswersNext', $data['showAnswersNext']);
    		$this->view->assign('useJoker', $data['useJoker']);
    		$this->view->assign('nextJoker', (($data['useJoker'] == 1) ? 2 : 0));
    		$this->view->assign("sysLanguageUid", $sys_language_uid);
    		$this->view->assign('uidOfPage', $GLOBALS['TSFE']->id);
			
    		$this->view->assign('from', $from);
    		$this->view->assign('to', $to);
    		$this->view->assign('uidOfCE', ($this->request->hasArgument('uidOfCE') ? intval($this->request->getArgument('uidOfCE')) : 0));
    //	} else {
    //		$this->view->assign('error', 1);
    //	}
    }
    
    /**
     * action result
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function resultAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
    	$languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
    	$sys_language_uid = $languageAspect->getId();
    	$pid = (int)$GLOBALS['TSFE']->id;
	    $debug = $this->setAllUserAnswers($quiz, $pid, false);
    	$this->view->assign('quiz', $quiz);
    	$this->view->assign('debug', $debug);
    	$this->view->assign("sysLanguageUid", $sys_language_uid);
    	$this->view->assign('uidOfPage', $pid);
    	$this->view->assign('uidOfCE', $this->configurationManager->getContentObject()->data['uid']);
    }

    /**
     * action highscore
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function highscoreAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $pid = (int)$GLOBALS['TSFE']->id;
        $participants = $this->participantRepository->findFromQuizLimit($quiz->getUid(), intval($this->settings['highscoreLimit']));
        $debug = '';
        $this->view->assign('quiz', $quiz);
        $this->view->assign('participants', $participants);
        $this->view->assign('debug', $debug);
        $this->view->assign("sysLanguageUid", $sys_language_uid);
        $this->view->assign('uidOfPage', $pid);
        $this->view->assign('uidOfCE', $this->configurationManager->getContentObject()->data['uid']);
    }

    /**
     * Action list for the backend
     *
     * @return 	void
     */
    function indexAction()
    {
    	$pid = (int)GeneralUtility::_GP('id');
    	$quizzes = $this->quizRepository->findFromPid($pid);
    	$this->view->assign('pid', $pid);
    	$this->view->assign('quizzes', $quizzes);
    }
    
    /**
     * action show for the backend
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function detailAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
    	$questionRepository = $this->objectManager->get('Fixpunkt\\FpMasterquiz\\Domain\\Repository\QuestionRepository');
    	$pid = (int)GeneralUtility::_GP('id');
    	$uid = (int)$quiz->getUid();
    	$updated = false;
    	$lost = $this->request->hasArgument('lost') ? intval($this->request->getArgument('lost')) : 0;
    	if ($lost > 0) {
    		// wir fügen erst eine verschollene Frage ohne Referenz hinzu
    		$question2 = $questionRepository->findbyUid($lost);
    		$quiz->addQuestion($question2);
    		$this->quizRepository->update($quiz);
    		$persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
    		$persistenceManager->persistAll();
    		$updated = true;
    		$this->addFlashMessage(
    			LocalizationUtility::translate('text.questionAdded', 'fp_masterquiz'),
    			LocalizationUtility::translate('text.updated', 'fp_masterquiz'),
    			\TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
    			false
    		);
   			// bringt auch NICHTS: $quiz = $this->quizRepository->findbyUid($uid);
    	}
    	$lostArray = [];
    	$lostQuestions = $questionRepository->findLostQuestions($pid);
    	foreach ($lostQuestions as $question) {
    		$lostArray[$question->getUid()] = $question->getTitle();
    	}
    	$this->view->assign('quiz', $quiz);
    	$this->view->assign('lostArray', $lostArray);
    	$this->view->assign('lost', count($lostArray));
    	$this->view->assign('updated', $updated);
    	if ($this->request->hasArgument('prop')) {
    		$this->view->assign('prop', $this->request->getArgument('prop'));
    	} else {
    		$this->view->assign('prop', 0);
    	}
    	if ($this->request->hasArgument('user')) {
    		$this->view->assign('user', $this->request->getArgument('user'));
    	} else {
    		$this->view->assign('user', 0);
    	}
    	if ($this->request->hasArgument('chart')) {
    		$this->view->assign('chart', $this->request->getArgument('chart'));
    	} else {
    		$this->view->assign('chart', 0);
    	}
    }
    
    /**
     * action charts for the backend
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function chartsAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
    	$be = $this->request->hasArgument('be') ? true : false;
    	if ($be) {
    		$pid = (int)GeneralUtility::_GP('id');
    	} else {
    		$pid = (int)$GLOBALS['TSFE']->id;
    	}
    	$debug = $this->setAllUserAnswers($quiz, $pid, $be);
    	$this->view->assign('debug', $debug);
    	$this->view->assign('pid', $pid);
    	$this->view->assign('quiz', $quiz);
    }
    
    /**
     * Send an email
     * 
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @param string $templateName template name (UpperCamelCase)
     * @param array $variables variables to be passed to the Fluid view
     * @param boolean $toAdmin email to the admin?
     * @return boolean TRUE on success, otherwise false
     */
    protected function sendTemplateEmail(array $recipient, array $sender, $subject, $templateName, array $variables = array(), $toAdmin = false)
    {
    	$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(
    		\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
    	);
    	
    	/** @var \TYPO3\CMS\Fluid\View\StandaloneView $emailView */
    	$emailViewHtml = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
    	$emailViewHtml->setTemplateRootPaths($extbaseFrameworkConfiguration['view']['templateRootPaths']);
    	$emailViewHtml->setLayoutRootPaths($extbaseFrameworkConfiguration['view']['layoutRootPaths']);
    	$emailViewHtml->setPartialRootPaths($extbaseFrameworkConfiguration['view']['partialRootPaths']);
    	$emailViewHtml->setTemplate('Email/' . $templateName . '.html');
    	$emailViewHtml->setFormat('html');
    	$emailViewHtml->assignMultiple($variables);
    	$emailBodyHtml = $emailViewHtml->render();
    	//echo "###" . $emailBodyHtml . '###';
        
    	/** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
    	$message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        foreach ($recipient as $key => $value) {
            $email = $key;
            $name = $value;
        }
        $message->to(
            new \Symfony\Component\Mime\Address($email, $name)
        );
        foreach ($sender as $key => $value) {
            $email = $key;
            $name = $value;
        }
        $message->from(
            new \Symfony\Component\Mime\Address($email, $name)
        );
        $message->subject($subject);
        $message->html($emailBodyHtml);
    	$message->send();
    	return $message->isSent();
    }
}
