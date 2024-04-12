<?php

namespace Fixpunkt\FpMasterquiz\Controller;

use Fixpunkt\FpMasterquiz\Domain\Repository\QuizRepository;
use Fixpunkt\FpMasterquiz\Domain\Repository\AnswerRepository;
use Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository;
use Fixpunkt\FpMasterquiz\Domain\Repository\SelectedRepository;
use Fixpunkt\FpMasterquiz\Domain\Repository\QuestionRepository;
use Fixpunkt\FpMasterquiz\Domain\Model\Participant;
use Fixpunkt\FpMasterquiz\Domain\Model\Quiz;
use Fixpunkt\FpMasterquiz\Domain\Model\Selected;
use Fixpunkt\FpMasterquiz\Domain\Model\Question;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use Psr\Log\LoggerInterface;

/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2024 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt für digitales GmbH
 *
 ***/

/**
 * QuizController
 */
class QuizController extends ActionController
{
    protected int $id;

    protected ModuleTemplate $moduleTemplate;

    /**
     * quizRepository
     *
     * @var QuizRepository
     */
    protected $quizRepository = null;

    /**
     * answerRepository
     *
     * @var AnswerRepository
     */
    protected $answerRepository = null;

    /**
     * participantRepository
     *
     * @var ParticipantRepository
     */
    protected $participantRepository = null;

    /**
     * selectedRepository
     *
     * @var SelectedRepository
     */
    protected $selectedRepository = null;

    /**
     * participant
     *
     * @var Participant
     */
    protected $participant = null;

    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @var PersistenceManagerInterface
     */
    protected $persistenceManager;

    public function __construct(protected readonly ModuleTemplateFactory $moduleTemplateFactory, private readonly LoggerInterface $logger)
    {
    }

    public function initializeIndexAction()
    {
        $this->id = (int)($this->request->getQueryParams()['id'] ?? 0);
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    }
    public function initializeDetailAction()
    {
        $this->id = (int)($this->request->getQueryParams()['id'] ?? 0);
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    }
    public function initializeChartsAction()
    {
        $this->id = (int)($this->request->getQueryParams()['id'] ?? 0);
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    }

    /**
     * Injects the quiz-Repository
     */
    public function injectQuizRepository(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    /**
     * Injects the answer-Repository
     */
    public function injectAnswerRepository(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * Injects the selected-Repository
     */
    public function injectSelectedRepository(SelectedRepository $selectedRepository)
    {
        $this->selectedRepository = $selectedRepository;
    }

    /**
     * Injects the participant-Repository
     */
    public function injectParticipantRepository(ParticipantRepository $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    public function injectPersistenceManager(PersistenceManagerInterface $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * Initializes the current action
     */
    public function initializeAction()
    {
        $tsSettings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        );
        if (isset($tsSettings['plugin.']['tx_fpmasterquiz.'])) {
            $tsSettings = $tsSettings['plugin.']['tx_fpmasterquiz.']['settings.'];
            $originalSettings = $this->configurationManager->getConfiguration(
                ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
            );
            // if flexform setting is empty and value is available in TS
            $overrideFlexformFields = GeneralUtility::trimExplode(',', $tsSettings['overrideFlexformSettingsIfEmpty'], true);
            foreach ($overrideFlexformFields as $fieldName) {
                if (str_contains($fieldName, '.')) {
                    // Multilevel
                    $keyAsArray = explode('.', $fieldName);
                    if ((!isset($originalSettings[$keyAsArray[0]][$keyAsArray[1]]) || !($originalSettings[$keyAsArray[0]][$keyAsArray[1]]))
                        && isset($tsSettings[$keyAsArray[0] . '.'][$keyAsArray[1]])) {
                        $originalSettings[$keyAsArray[0]][$keyAsArray[1]] = $tsSettings[$keyAsArray[0] . '.'][$keyAsArray[1]];
                    }
                } else {
                    // Simple
                    if ((!isset($originalSettings[$fieldName]) || !($originalSettings[$fieldName]))
                        && isset($tsSettings[$fieldName])) {
                        $originalSettings[$fieldName] = $tsSettings[$fieldName];
                    }
                }
            }
            $this->settings = $originalSettings;
        }
    }

    /*
    * Sucht ein default-Quiz
    */
    protected function getDefaultQuiz()
    {
        $quiz = null;
        $defaultQuizUid = $this->getLocalizedDefaultQuiz();
        if ($defaultQuizUid) {
            $quiz = $this->quizRepository->findOneBy(['uid' => $defaultQuizUid]);
        }
        if (!$quiz) {
            $this->addFlashMessage(
                LocalizationUtility::translate('error.quizNotFound', 'fp_masterquiz') . ' uid=' . $defaultQuizUid,
                LocalizationUtility::translate('error.error', 'fp_masterquiz'),
                ContextualFeedbackSeverity::WARNING,
                false
            );
        }
        return $quiz;
    }

    /**
     * Holt die echte Quiz-UID
     *
     * @return integer
     */
    protected function getLocalizedDefaultQuiz()
    {
        $defaultQuizUid = intval($this->settings['defaultQuizUid']);
        if (!$defaultQuizUid) {
            return 0;
        } else {
            $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
            $sys_language_uid = $languageAspect->getId();
            if ($sys_language_uid > 0) {
                $localizedUid = $this->quizRepository->getMyLocalizedUid($defaultQuizUid, $sys_language_uid);
                //echo "aus $defaultQuizUid, $sys_language_uid wird $localizedUid";
                if ($localizedUid) {
                    $defaultQuizUid = $localizedUid;
                }
            }
        }
        return $defaultQuizUid;
    }

    /**
     * Prüft, ob eine Session gültig ist: check the session against the request-parameter
     *
     * @return boolean
     */
    public function isSessionOK(string &$c_debug): bool
    {
        if ($this->request->hasArgument('session')) {
            $tmp_session = $this->request->getArgument('session');
        } else {
            $tmp_session = '';
        }
        if ($this->participant->getSession() != $tmp_session) {
            $this->participant = null;
            if ($this->settings['debug']) {
                $c_debug .= "\nParticipant not accepted, because the session from argument is wrong: " . $tmp_session;
            }
            return false;
        }
        return true;
    }

    /**
     * Sucht einen Teilnehmer und erzeugt ggf. einen
     *
     * @return array
     */
    public function findParticipant(int $quizUid, int $quizPid)
    {
        $session = '';          // session key
        $debug = '';
        $participated = 0;
        $newUser = false;
        $context = GeneralUtility::makeInstance(Context::class);
        $fe_user_uid = intval($context->getPropertyFromAspect('frontend.user', 'id'));
        $isAjax = $this->settings['ajax'];
        if ($this->settings['debug'] && $isAjax) {
            $debug .= "\nAjax mode is enabled.";
        }
//        if (!$isAjax) {
        if ($this->request->hasArgument('session')) {
            // wir dürften nicht auf der Startseite sein, außer beim 1. Ajax-call
            $session = $this->request->getArgument('session');
        } else if (!$this->request->hasArgument('participant') && !$isAjax) {
            // keine Session gefunden... und jetzt Cookie checken? Hier dürften wir auf der Startseite sein
            if (intval($this->settings['user']['useCookie']) == -1) {
                $session = $GLOBALS["TSFE"]->fe_user->getKey('ses', 'qsession' . $quizUid);
            } else if ((intval($this->settings['user']['useCookie']) > 0) && isset($_COOKIE['qsession' . $quizUid])) {
                $session = $_COOKIE['qsession' . $quizUid];
            }
            if ($session) {
                $this->participant = $this->participantRepository->findOneBy(['session' => $session]);
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
                        if ($this->settings['user']['checkFEuser'] > 1) {
                            $allowedParticipations = intval($this->settings['user']['checkFEuser']);
                            $participated = $this->participantRepository->findCountByUserAndQuiz($fe_user_uid, $quizUid);
                            if (($participated >= $allowedParticipations) || !$this->participant->isCompleted()) {
                                if ($this->settings['debug']) {
                                    $debug .= "\n" . $participated . 'x participated; no restriction.';
                                }
                            } else {
                                // Reset a completed participant to allow a new "Teilnahme"
                                $this->participant = null;
                                if ($this->settings['debug']) {
                                    $debug .= "\n" . $participated . 'x participated; allow more participations.';
                                }
                            }
                        }
                        if ($this->participant) {
                            $session = $this->participant->getSession();
                            if ($this->settings['debug']) {
                                $debug .= "\nsession from FEuser: " . $session . '; and the participant-uid: ' . $this->participant->getUid();
                            }
                        }
                    }
                }
                if (!$session) {
                    $this->participant = null;
                    if ($this->settings['debug']) {
                        $debug .= "\nNo session found, will creating a new participant...";
                    }
                }
            }
        }
//        }

        if ($this->request->hasArgument('participant') && $this->request->getArgument('participant')) {
            // wir sind nicht auf Seite 1
            $participantUid = intval($this->request->getArgument('participant'));
            if ($this->settings['user']['useQuizPid']) {
                $this->participant = $this->participantRepository->findOneByUidAndPid($participantUid, $quizPid);
            } else {
                $this->participant = $this->participantRepository->findOneBy(['uid' => $participantUid]);
            }
            if ($this->participant) {
                // ein abgelegter session-key hat Vorrang
                $session = $this->participant->getSession();
                if ($session && !$this->isSessionOK($debug)) {
                    $participantUid = 0;
                }
                if ($this->settings['debug'] && $participantUid) {
                    $debug .= "\nParticipant from request: " . $participantUid . ' with session: ' . $session;
                }
            }
        }
        if (!$this->participant) {
            $this->participant = GeneralUtility::makeInstance(Participant::class);
            $this->participant->_setProperty('_languageUid', -1);
            if ($this->settings['debug']) {
                $debug .= "\nMaking new participant.";
            }
            if ($this->settings['user']['useQuizPid']) {
                $this->participant->setPid($quizPid);
                if ($this->settings['debug']) {
                    $debug .= ' Set pid to ' . $quizPid;
                }
            }
            if ($this->settings['random'] && $this->request->hasArgument('randomPages') && $this->request->getArgument('randomPages')) {
                $this->participant->setRandompages(explode(',', (string) $this->request->getArgument('randomPages')));
                if ($this->settings['debug']) {
                    $debug .= " Set random pages: " . $this->request->getArgument('randomPages');
                }
            }
            if (!$session) {
                // ggf. wird die Session von der Startseite beibehalten
                $session = uniqid(random_int(1000, 9999));
                $this->participant->setSession($session);
                $newUser = true;
                if ($this->settings['debug']) {
                    $debug .= "\ncreating new session: " . $session;
                }
            }
        }
        if (!$isAjax && !$newUser && !$this->participant->getUid()) {
            // Cookie nicht schon auf der Startseite setzen, sondern erst und nur auf der Folgeseite
            if ($this->settings['debug']) {
                $debug .= "\nSetting a cookie with this session: " . $session;
            }
            if (intval($this->settings['user']['useCookie']) == -1) {
                // Store the session in a cookie
                $GLOBALS['TSFE']->fe_user->setKey('ses', 'qsession' . $quizUid, $session);
                $GLOBALS["TSFE"]->fe_user->storeSessionData();
            } else if (intval($this->settings['user']['useCookie']) > 0) {
                setcookie('qsession' . $quizUid, (string) $session, ['expires' => time() + (3600 * 24 * intval($this->settings['user']['useCookie']))]);  /* verfällt in x Tagen */
            }
        }
        $result = [];
        $result['session'] = $session;
        $result['newUser'] = $newUser;
        $result['fe_user_uid'] = $fe_user_uid;
        $result['participated'] = $participated;
        $result['debug'] = $debug;
        return $result;
    }

    /**
     * Setzt Name, E-Mail und Homepage, falls vorhanden
     *
     * @return void
     */
    protected function setUserData(string $defaultName = '', string $defaultEmail = '', string $defaultHomepage = '') {
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
        if ($defaultName) {
            $this->participant->setName($defaultName);
        }
        if ($defaultEmail) {
            $this->participant->setEmail($defaultEmail);
        }
        if ($defaultHomepage) {
            $this->participant->setHomepage($defaultHomepage);
        }
    }
    
    /**
     * do All: evaluate selections
     *
     * @param array $userData Some user data in an array
     * @param int $pages No. of pages if tags are used
     * @param array $randomNumbers Random page numbers
     * @return array
     */
    public function doAll(Quiz $quiz, array $userData, int $pages, array $randomNumbers): array
    {
        $saveIt = false;
        $reload = false;
        $mandatoryNotAnswered = false;
        $doPersist = false;
        $partBySes = null;
        $maximum1 = 0;              // maximum points
        $finalBodytext = '';        // bodytext and image for the final page
        $finalImageuid = 0;         // image for the final page
        $finalContent = '';            // special content for the final page
        $finalCategoryArray = [];   // Auswertung der angeklickten Kategorien
        $redirectTo = '';             // redirect to uri (after evaluation)
        $emailAnswers = [];            // special admin email to answer relations
        $specialRecievers = [];        // special admin email recievers
        $debug = $userData['debug'];        // debug output
        $session = $userData['session'];    // session key
        $newUser = $userData['newUser'];    // is a new user?
        $fe_user_uid = $userData['fe_user_uid'];    // FE user uid
        $quizPid = $quiz->getPid();
        $isClosed = $this->settings['closed'];  // quiz closed?
        $phpFormCheck = $this->settings['phpFormCheck'];
        $questionsPerPage = intval($this->settings['pagebrowser']['itemsPerPage']);
        $showAnswers = $this->request->hasArgument('showAnswers') ? intval($this->request->getArgument('showAnswers')) : 0;
        $useJoker = $this->request->hasArgument('useJoker') ? intval($this->request->getArgument('useJoker')) : 0;
        $startTime = $this->request->hasArgument('startTime') ? intval($this->request->getArgument('startTime')) : 0;
        $page = $this->request->hasArgument('currentPage') ? intval($this->request->getArgument('currentPage')) : 1;
        $reachedPage = $this->participant->getPage();
        if (!$questionsPerPage || $this->settings['ajax']) {
            $questionsPerPage = 1;
        }
        /* if ($this->settings['ajax'] && $session && !$this->participant->getUid() && ($showAnswers || $page>1)) {
             $page = 1;
             $showAnswers = false;
             $reload = true;
             if ($this->settings['debug']) {
                 $debug .= "\nReload auf Ajax-Startseite detektiert.";
             }
         } */
        if ($this->settings['allowEdit']) {
            if ($this->participant->isCompleted() && (intval($this->settings['allowEdit']) < 2)) {
                $showAnswers = true;
            } else {
                $showAnswers = false;
            }
            $showAnswerPage = false;
        } else {
            if ($reachedPage >= $page) {
                // beantwortete Seiten soll man nicht nochmal beantworten können
                $showAnswers = true;
            }
            $showAnswerPage = intval($this->settings['showAnswerPage']);
        }
        if ($showAnswerPage && !$showAnswers) {
            // als Nächstes erstmal die Antworten dieser Seite zeigen
            $nextPage = $page;
        } else {
            $nextPage = $page + 1;
        }
        if ($showAnswers) {
            $lastPage = $page;
        } else {
            $lastPage = $page - 1;
        }
        $questions = count($quiz->getQuestions());
        if ($showAnswers || (!$showAnswerPage && $page > 1)) {
            // Antworten sollen ausgewertet und gespeichert werden
            if (($reachedPage < $page) || $this->settings['allowEdit']) {
                // nur nicht beantwortete Seiten speichern, es sei denn allowEdit=1
                $saveIt = true;
            }
            if (!$this->participant->getUid()) {
                if (!$newUser && $session) {
                    $partBySes = $this->participantRepository->findOneBy(['session' => $session]);
                }
                if ($partBySes) {
                    $this->participant = $partBySes;
                    $reload = true;
                    if ($this->settings['debug']) {
                        $debug .= "\nReload nach absenden von Seite 1 detektiert.";
                    }
                } elseif (!$isClosed) {
                    if ($this->settings['user']['checkFEuser'] && $fe_user_uid) {
                        $feuserData = $this->getFeUser($fe_user_uid);
                        $defaultName = $feuserData['name'];
                        $defaultEmail = $feuserData['email'];
                        $defaultHomepage = $feuserData['www'];
                    } else {
                        $defaultName = $this->settings['user']['defaultName']??'';
                        $defaultName = str_replace('{TIME}', date('Y-m-d H:i:s'), (string) $defaultName);
                        $defaultEmail = $this->settings['user']['defaultEmail']??'';
                        $defaultHomepage = $this->settings['user']['defaultHomepage']??'';
                    }
                    $this->setUserData($defaultName, $defaultEmail, $defaultHomepage);
                    $this->participant->setUser(isset($GLOBALS['TSFE']->fe_user->user['uid']) ? intval($GLOBALS['TSFE']->fe_user->user['uid']) : 0);
                    $this->participant->setIp($this->getRealIpAddr());
                    // Die Session wurde bisher nur auf der Startseite gesetzt, deshalb wird sie hier nochmal gesetzt
                    $this->participant->setSession($session);
                    if ($startTime) {
                        $this->participant->setSessionstart(time() - $startTime);
                    }
                    if ($this->settings['random'] && count($randomNumbers) > 1) {
                        $this->participant->setRandompages($randomNumbers);
                    }
                    $this->participant->setQuiz($quiz);
                    $this->participant->setMaximum2($quiz->getMaximum2(intval($this->settings['pointsMode'])));
                    $this->participantRepository->add($this->participant);
                    $this->persistenceManager->persistAll();
                    $newUser = true;
                    if ($this->settings['debug']) {
                        $debug .= "\nNew participant created: " . $this->participant->getUid() . '; with session: ' . $session;
                    }
                }
            } else if ($this->settings['allowEdit'] && !$isClosed && !$this->participant->isCompleted()) {
                // geänderte Userdaten nicht mehr ignorieren
                $this->setUserData();
            }
        }
        $completed = $this->participant->isCompleted();
        if ($isClosed) {
            $completed = true;
        }

        // Ausgewählte Antworten auswerten und speichern
        if ($saveIt && !$reload && (!$completed || $this->settings['allowEdit'] == 2) && ($useJoker != 1)) {
            // special preparation
            if ($this->settings['email']['sendToAdmin'] && $this->settings['email']['specific']) {
                $emailAnswers = json_decode((string) $this->settings['email']['specific'], true);
                //var_dump($emailAnswers);
            }
            $i = 0;
            // cycle through all questions after a form-submit
            foreach ($quiz->getQuestions() as $question) {
                $quid = $question->getUid();
                $debug .= "\n#" . $quid . '#: ';
                if ($this->request->hasArgument('quest_' . $quid) && $this->request->getArgument('quest_' . $quid)) {
                    $isActive = true;
                } else if (isset($_POST['quest_' . $quid]) || isset($_GET['quest_' . $quid])) {
                    // Ajax-call is without extension-name :-(
                    $isActive = true;
                } else {
                    $isActive = false;
                }
                if ($isActive) {
                    // Auswertung der abgesendeten Fragen
                    $vorhanden = 0;
                    if (!$newUser) {
                        // zuerst prüfen, ob dieser Eintrag schon existiert (z.B. durch Reload)
                        $vorhanden = $this->selectedRepository->countByParticipantAndQuestion($this->participant->getUid(), $quid);
                    }
                    if (($vorhanden > 0) && !$this->settings['allowEdit']) {
                        $debug .= ' reload!? ';
                    } else {
                        $qmode = $question->getQmode();
                        $pmode = intval($this->settings['pointsMode']);
                        $question->setPmode($pmode);    // wird aber nicht benutzt
                        $isOptional = ($this->settings['noFormCheck'] || $question->isOptional() || $qmode == 4 || $qmode == 7) ? true : false;
                        if ($this->settings['debug']) {
                            $debug .= ' OK ' . (($isOptional) ? 'optional: ' : 'mandatory: ');
                        }
                        // selected/answered question
                        if ($vorhanden) {
                            // alten Eintrag erst löschen
                            //$this->selectedRepository->deleteByParticipantAndQuestion($this->participant->getUid(), $quid);
                            $oldSelection = $this->selectedRepository->findByParticipantAndQuestion($this->participant->getUid(), $quid);
                            if ($oldSelection) {
                                $oldPoints = $oldSelection->getPoints();
                                $this->participant->subtractPoints($oldPoints);
                                $this->participant->removeSelection($oldSelection);
                                $debug .= ' (removing selection ' . $oldSelection->getUid() .') ';
                                $this->selectedRepository->deleteSelection($oldSelection->getUid());
                            }
                        }
                        $selected = GeneralUtility::makeInstance(Selected::class);
                        $selected->_setProperty('_languageUid', -1);
                        if ($this->settings['user']['useQuizPid']) {
                            $selected->setPid($quizPid);
                        }
                        $selected->setQuestion($question);
                        if ($pages) {
                            // bei Verwendung von Tags kann die Reihenfolge nicht mit der Reihenfolge der Fragen übereinstimmen
                            $sorting = $page * 100 + $i;
                        } else {
                            // Reihenfolge der Fragen übernehmen
                            $sorting = $question->getSorting();
                        }
                        $selected->setSorting($sorting);
                        $selectedWithAnswer = false;
                        $qmode8Answers = [];
                        $newPoints = 0;
                        $questionPoints = 0;
                        switch ($qmode) {
                            case 0:
                            case 4:
                            case 8:
                                // Checkbox, ja/nein und Kategorie-Matrix
                                foreach ($question->getAnswers() as $answer) {
                                    $auid = $answer->getUid();
                                    $selectedCategoryUid = 0;
                                    if ($this->request->hasArgument('answer_' . $quid . '_' . $auid) && $this->request->getArgument('answer_' . $quid . '_' . $auid)) {
                                        $selectedAnswerUid = intval($this->request->getArgument('answer_' . $quid . '_' . $auid));
                                    } else if (isset($_POST['answer_' . $quid . '_' . $auid])) {
                                        $selectedAnswerUid = intval($_POST['answer_' . $quid . '_' . $auid]);
                                    } else if (isset($_GET['answer_' . $quid . '_' . $auid])) {
                                        $selectedAnswerUid = intval($_GET['answer_' . $quid . '_' . $auid]);
                                    } else {
                                        $selectedAnswerUid = -1;
                                    }
                                    if ($selectedAnswerUid > 0) {
                                        if ($qmode == 8) {
                                            // im Matrix-Modus wird eine Kategorie-UID übermittelt!
                                            $selectedCategoryUid = $selectedAnswerUid;
                                            $selectedAnswerUid = $auid;
                                            $qmode8Answers[$auid] = $selectedCategoryUid;
                                            // für propertiesSent wird die eigene Antwort benötigt
                                            foreach ($question->getCategories() as $oneCategory) {
                                                if ($oneCategory->getUid() == $selectedCategoryUid) {
                                                    $answer->setOwnCategoryAnswer([$selectedCategoryUid, $oneCategory->getTitle()]);
                                                    break;
                                                }
                                            }
                                        } elseif ($selectedAnswerUid != $auid) {
                                            // dies sollte nie der Fall sein, deshalb erlauben wir das nicht
                                            $selectedAnswerUid = -1;
                                        }
                                    }
                                    if ($this->settings['debug']) {
                                        $debug .= $quid . '_' . $auid . '-' . $selectedAnswerUid . ' ';
                                    }
                                    if ($selectedAnswerUid > 0) {
                                        // für PHP-check; im FE müssen Eingaben im Fehlerfall übernommen werden
                                        $answer->setOwnAnswer(1);
                                        // wir brauchen theoretisch kein select mehr, denn die aktuelle Antwort ist die ausgewählte!
                                        //$selectedAnswer = $this->answerRepository->findByUid($selectedAnswerUid);
                                        $newPoints = $answer->getPoints();
                                        // halbierte Punkte setzen? Ändert aber die echte Antwort!
                                        // so nicht: $selectedAnswer->setPoints($newPoints);
                                        if ($newPoints != 0) {
                                            if ($useJoker == 2) {
                                                // Joker wurde eingesetzt: Punkte halbieren
                                                $newPoints = intval(ceil($newPoints / 2));
                                            }
                                            // jetzt später: $selected->addPoints($newPoints);
                                            //if (($pmode==4 && $questionPoints==0) || $pmode<4) {
                                                $questionPoints += $newPoints;
                                            //}
                                        }
                                        $selected->addAnswer($answer);
                                        $selectedWithAnswer = true;
                                        if (isset($emailAnswers[$quid][$auid])) {
                                            $specialRecievers[$emailAnswers[$quid][$auid]['email']] = $emailAnswers[$quid][$auid];
                                        }
                                    }
                                }
                                if ($questionPoints != 0) {
                                    if (($pmode<3) ||
                                        ($questionPoints==$question->getMaximum1())) {
                                        if ($pmode>0 && $questionPoints<0) {
                                            $questionPoints = 0;
                                        }
                                        if ($pmode == 4) {
                                            $questionPoints = 1;
                                        }
                                        $selected->setPoints($questionPoints);
                                        $this->participant->addPoints($questionPoints);
                                        if ($this->settings['debug']) {
                                            $debug .= $questionPoints . 'P ';
                                        }
                                    }
                                }
                                if (!$vorhanden) {
                                    $maximum1 += (($pmode == 4) ? 1 : $question->getMaximum1());
                                }
                                break;
                            case 1:
                            case 2:
                            case 7:
                                // Radio-box, Select-option und star rating
                                if ($this->request->hasArgument('answer_' . $quid) && $this->request->getArgument('answer_' . $quid)) {
                                    $selectedAnswerUid = intval($this->request->getArgument('answer_' . $quid));
                                } else if (isset($_POST['answer_' . $quid])) {
                                    $selectedAnswerUid = intval($_POST['answer_' . $quid]);
                                } else if (isset($_GET['answer_' . $quid])) {
                                    $selectedAnswerUid = intval($_GET['answer_' . $quid]);
                                } else {
                                    $selectedAnswerUid = 0;
                                }
                                if ($this->settings['debug']) {
                                    $debug .= $quid . '-' . $selectedAnswerUid . ' ';
                                }
                                if ($selectedAnswerUid) {
                                    $selectedAnswer = $this->answerRepository->findByUid($selectedAnswerUid);
                                    $selectedAnswer->setOwnAnswer(1);       // für PHP-check
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
                                            $newPoints = intval(ceil($newPoints / 2));
                                        }
                                        if ($pmode>0 && $newPoints<0) {
                                            $newPoints = 0;
                                        }
                                        if ($pmode==4 && $newPoints>0) {
                                            $newPoints = 1;
                                        }
                                        $selected->addPoints($newPoints);
                                        $this->participant->addPoints($newPoints);
                                        if ($this->settings['debug']) {
                                            $debug .= $newPoints . 'P ';
                                        }
                                    }
                                    $selected->addAnswer($selectedAnswer);
                                    $selectedWithAnswer = true;
                                    if (isset($emailAnswers[$quid][$selectedAnswerUid])) {
                                        $specialRecievers[$emailAnswers[$quid][$selectedAnswerUid]['email']] = $emailAnswers[$quid][$selectedAnswerUid];
                                    }
                                }
                                if (!$vorhanden) {
                                    $maximum1 += (($pmode == 4) ? 1 : $question->getMaximum1());
                                }
                                break;
                            case 3:
                            case 5:
                                // When enter an answer in a textbox: try to evaluate the answer of the textbox
                                $tmpMaximum1 = $this->evaluateInputTextAnswerResult($quid, $question, $selected, $debug);
                                if ($phpFormCheck && $selected->getEntered()) {
                                    $selectedWithAnswer = true;
                                    // für PHP-check: im FE werden die Eingaben im Fehlerfall benötigt
                                    $ownAnswer = [];
                                    $ownAnswer[] = $selected->getEntered();
                                    $question->setTextAnswers($ownAnswer);
                                }
                                if (!$vorhanden) {
                                    $maximum1 += (($pmode == 4) ? 1 : $tmpMaximum1);
                                }
                                break;
                            default:
                                // hier passiert nichts
                        }
                        if ($phpFormCheck && !$isOptional && !$selectedWithAnswer) {
                            if ($this->settings['debug']) {
                                $debug .= "\n!!! Mandatory question not answered !!!";
                            }
                            $mandatoryNotAnswered = true;
                        } else {
                            if ($qmode == 8) {
                                // Die Kategorie-Auswahl wird als Text gespeichert :-(
                                $selected->setEntered(serialize($qmode8Answers));
                            }
                            // TODO: ist das hier sinnvoll?
                            //$this->selectedRepository->add($selected);
                            //$this->persistenceManager->persistAll();
                            // assign the selected dataset to the participant
                            $this->participant->addSelection($selected);
                        }
                    }
                }
                $i++;
            }
            if (!$mandatoryNotAnswered) {
                // Update the participant result
                if ($maximum1 > 0) {
                    $this->participant->addMaximum1($maximum1);
                }
                $this->participant->setPage($lastPage);
                $this->participantRepository->update($this->participant);
                //$doPersist = true;
                // better persist data before evaluation!
                $this->persistenceManager->persistAll();
            }
        }
        if (!$pages) {
            $pages = intval(ceil($questions / $questionsPerPage));
        }

        if (!$mandatoryNotAnswered) {
            // toggle mode for show answers after submit questions
            if ($showAnswerPage) {
                $showAnswersNext = $showAnswers == 1 ? 0 : 1;
            } else {
                $showAnswersNext = 0;
            }
        } else {
            // benötigte Felder wurden nicht ausgefüllt
            $showAnswers = 0;
            $nextPage = $this->request->hasArgument('currentPage') ? intval($this->request->getArgument('currentPage')) : 1;
            if ($showAnswerPage) {
                $showAnswersNext = 1;
            } else {
                $showAnswersNext = 0;
                $nextPage++;
            }
        }

        if (!$showAnswers && $quiz->getTimeperiod() && ($this->participant->getTimePassed() >= $quiz->getTimeperiod())) {
            // Die Zeit für ein Quiz ist abgelaufen: auf zur finalen Seite
            $page = $pages + 1;
            $nextPage = $page;
        }

        if ($this->settings['debug']) {
            $debug .= "\nlast page: " . $lastPage . '; page: ' . $page . '; reached page before: ' . $reachedPage . '; next page: ' . $nextPage . '; showAnswers: ' . $showAnswers . '; showAnswersNext: ' . $showAnswersNext;
            $debug .= "\nqs/qpp=pages#" . $questions . '/' . $questionsPerPage . '=' . $pages;
            $debug .= "\ntime period=" . $quiz->getTimeperiod() . '; time passed: ' . $this->participant->getTimePassed();
        }

        if ($page > $pages) {
            // finale Auswertung ...
            $final = 1;
            $showAnswersNext = 0;
            foreach ($quiz->getEvaluations() as $evaluation) {
                $categories = $evaluation->getCategories();
                $categoryUid = 0;
                $finalCategory = 0;
                $finalPoints = 0;
                if ($categories->count()) {
                    foreach ($categories as $category) {
                        $categoryUid = $category->getUid();
                        break;
                    }
                    if ($categoryUid) {
                        if (!isset($finalCategoryArray['uid'])) {
                            // hole die am meisten angeklickte Kategorie + andere Daten nur einmal
                            $finalCategoryArray = $this->participant->getCategoryMost();
                        }
                        $finalCategory = $finalCategoryArray['uid'];
                    }
                } else {
                    if (!$evaluation->isEvaluate()) {
                        // Punkte auswerten
                        $finalPoints = $this->participant->getPoints();
                    } else {
                        // Prozente auswerten
                        $finalPoints = $this->participant->getPercent2();
                    }
                }
                if (($categoryUid && $finalCategory == $categoryUid) ||
                    (!$categoryUid && ($finalPoints >= $evaluation->getMinimum()) && ($finalPoints <= $evaluation->getMaximum()))) {
                    // Punkte-Match
                    if ($evaluation->getPage() > 0) {
                        // Weiterleitung zu dieser Seite
                        $redirectTo = $this->uriBuilder->reset()
                                ->setTargetPageUid($evaluation->getPage())
                                ->build();
                    } else if ($evaluation->getCe() > 0) {
                        // Content-Element ausgeben
                        $ttContentConfig = [
                            'tables' => 'tt_content',
                            'source' => $evaluation->getCe(),
                            'dontCheckPid' => 1
                        ];
                        $finalContent = $GLOBALS['TSFE']->cObj->cObjGetSingle('RECORDS', $ttContentConfig);
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
                    if ($oneQuestion->getQmode() == 8) {
                        $oneQuestionCategories = $oneQuestion->getCategoriesArray();
                    } else {
                        $oneQuestionCategories = [];
                    }
                    $debug .= $this->setAllUserAnswersForOneQuestion($oneQuestion, 0, false);
                    // eigene Ergebnisse durchgehen
                    $ownResults = [];
                    foreach ($selection->getAnswers() as $oneAnswer) {
                        if ($this->settings['debug']) {
                            $debug .= "\n own:" . $oneAnswer->getTitle() . ': ' . $oneAnswer->getPoints() . "P";
                        }
                        if (isset($ownResults[$oneAnswer->getUid()])) {
                            $ownResults[$oneAnswer->getUid()]++;
                        } else {
                            $ownResults[$oneAnswer->getUid()] = 1;
                        }
                    }
                    foreach ($oneQuestion->getAnswers() as $oneAnswer) {
                        $own = 0;
                        if (isset($ownResults[$oneAnswer->getUid()])) {
                            $own = intval($ownResults[$oneAnswer->getUid()]);
                        }
                        $oneAnswer->setOwnAnswer($own);
                        if ($oneQuestion->getQmode() == 8) {
                            $ownCategoryAnswers = unserialize($selection->getEntered());
                            foreach ($ownCategoryAnswers as $key => $ownCategoryAnswer) {
                                if ($key == $oneAnswer->getUid()) {
                                    $oneAnswer->setOwnCategoryAnswer([$ownCategoryAnswer, $oneQuestionCategories[$ownCategoryAnswer]]);
                                }
                            }
                        }
                    }
                }
            } elseif ($this->settings['showOwnAnswers']) {
                // alle Fragen durchgehen, die der User beantwortet hat:
                foreach ($this->participant->getSortedSelections() as $selection) {
                    $oneQuestion = $selection->getQuestion();
                    if ($oneQuestion->getQmode() == 8) {
                        $oneQuestionCategories = $oneQuestion->getCategoriesArray();
                        $ownCategoryAnswers = unserialize($selection->getEntered());
                        foreach ($oneQuestion->getAnswers() as $oneAnswer) {
                            foreach ($ownCategoryAnswers as $key => $ownCategoryAnswer) {
                                if ($key == $oneAnswer->getUid()) {
                                    $oneAnswer->setOwnCategoryAnswer([$ownCategoryAnswer, $oneQuestionCategories[$ownCategoryAnswer]]);
                                }
                            }
                        }
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
                    if ($this->settings['email']['adminEmail']) {
                        $adminMails = explode( ',', (string) $this->settings['email']['adminEmail'] );
                        foreach ($adminMails as $email) {
                            if (GeneralUtility::validEmail(trim($email))) {
                                $this->sendTemplateEmail(
                                    [trim($email) => $this->settings['email']['adminName']],
                                    [$this->settings['email']['fromEmail'] => $this->settings['email']['fromName']],
                                    $this->settings['email']['adminSubject'],
                                    'ToAdmin',
                                    $dataArray,
                                    true
                                );
                                if ($this->settings['debug']) {
                                    $debug .= "\n sending admin-email to: " . $this->settings['email']['adminName']
                                        . ' <' . trim($email) . '> : ' . $this->settings['email']['adminSubject'];
                                }
                            }
                        }
                    }
                    if (!empty($specialRecievers)) {
                        foreach ($specialRecievers as $email => $emailArray) {
                            if (GeneralUtility::validEmail($email)) {
                                $this->sendTemplateEmail(
                                    [$email => $emailArray['name']],
                                    [$this->settings['email']['fromEmail'] => $this->settings['email']['fromName']],
                                    $emailArray['subject'],
                                    'ToAdmin',
                                    $dataArray,
                                    true
                                );
                                if ($this->settings['debug']) {
                                    $debug .= "\n sending special-admin-email to: " . $emailArray['name'] . ' <' . $email . '> : ' . $emailArray['subject'];
                                }
                            }
                        }
                    }
                }
                if ($this->settings['email']['sendToUser'] && GeneralUtility::validEmail($dataArray['email'])) {
                    $this->sendTemplateEmail(
                        [$dataArray['email'] => $dataArray['name']],
                        [$this->settings['email']['fromEmail'] => $this->settings['email']['fromName']],
                        $this->settings['email']['userSubject'],
                        'ToUser',
                        $dataArray,
                        false
                    );
                    if ($this->settings['debug']) {
                        $debug .= "\n sending user-email to: " . $dataArray['name'] . ' <' . $dataArray['email'] . '> : ' . $this->settings['email']['userSubject'];
                    }
                }
            }
            if (!$isClosed) {
                $this->participant->setCompleted(true);
                $this->participantRepository->update($this->participant);
                $doPersist = true;
            }
            if ($this->settings['redirectToResultPageAtFinal'] && $this->settings['resultPageUid'] && !$redirectTo) {
                $redirectTo = $this->uriBuilder->reset()
                    ->setTargetPageUid(intval($this->settings['resultPageUid']))
                    ->build();
            }
        } else {
            $final = 0;
        }
        if ($doPersist) {
            $this->persistenceManager->persistAll();
        }
        return [
            'page' => $page,
            'pages' => $pages,
            'lastPage' => $lastPage,
            'nextPage' => $nextPage,
            'questions' => $questions,
            'final' => $final,
            'finalContent' => $finalContent,
            'finalBodytext' => $finalBodytext,
            'finalImageuid' => $finalImageuid,
            'finalCategories' => $finalCategoryArray,
            'showAnswers' => $showAnswers,
            'showAnswersNext' => $showAnswersNext,
            'useJoker' => $useJoker,
            'mandatoryNotAnswered' => $mandatoryNotAnswered,
            'session' => $session,
            'participated' => $userData['participated'],
            'redirectTo' => $redirectTo,
            'debug' => $debug
        ];
    }

    /**
     * Update user data after the final page
     */
    protected function checkForClosure(): bool
    {
        $debug = '';
        $page = $this->request->hasArgument('currentPage') ? intval($this->request->getArgument('currentPage')) : 1;
        if (($page == 999) && ($this->settings['user']['askForData'] == 3) && $this->settings['closurePageUid'] &&
            $this->request->hasArgument('participant') && $this->request->getArgument('participant')) {
            $participantUid = intval($this->request->getArgument('participant'));
            $this->participant = $this->participantRepository->findOneBy(['uid' => $participantUid]);
            if ($this->isSessionOK($debug)) {
                if ($this->request->hasArgument('name') && $this->request->getArgument('name')) {
                    $this->participant->setName($this->request->getArgument('name'));
                }
                if ($this->request->hasArgument('email') && $this->request->getArgument('email')) {
                    $this->participant->setEmail($this->request->getArgument('email'));
                }
                if ($this->request->hasArgument('homepage') && $this->request->getArgument('homepage')) {
                    $this->participant->setHomepage($this->request->getArgument('homepage'));
                }
                $this->participantRepository->update($this->participant);
                $this->persistenceManager->persistAll();
                return true;
            }
        }
        return false;
    }

    /**
     * Try to evaluate the answer of an Input Textbox
     *
     * @param int $i_quid The Question ID
     * @param Question $i_question The Question dataset
     * @param Selected $c_selected The Selected dataset
     * @param string $c_debug Debug
     * @return int The max. possible points until the current question
     */
    protected function evaluateInputTextAnswerResult(int $i_quid, 
                                                   Question $i_question, 
                                                   Selected &$c_selected,
                                                   string &$c_debug)
    {
        $maximum1 = 0;
        // retreive answer over the GET arguments
        if ($this->request->hasArgument('answer_text_' . $i_quid) && $this->request->getArgument('answer_text_' . $i_quid)) {
            $answerText = $this->request->getArgument('answer_text_' . $i_quid);
            $c_debug .= "\n" . $i_quid . '- Answer in the Inputbox is: ' . $answerText . ' ';

            // retreive answer over the POST arguments
        } else if (isset($_POST['answer_text_' . $i_quid])) {
            $answerText = $_POST['answer_text_' . $i_quid];
            $c_debug .= "\n" . $i_quid . '- Answer in the Inputbox is: ' . $answerText . ' ';

            // retreive answer over the GET arguments
        } else if (isset($_GET['answer_text_' . $i_quid])) {
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
                $maximum1 += $answer->getPoints();

                // if the answer is right
                if (strtoupper(trim($answer->getTitle())) == strtoupper(trim($answerText))) {
                    $newPoints = $answer->getPoints();
                    if ($newPoints != 0) {
                        $c_selected->addPoints($newPoints);
                        $this->participant->addPoints($newPoints);
                        $c_debug .= "\n" . '+' . $newPoints . 'P ';
                    }
                }
            }
        }
        return $maximum1;
    }

    /**
     * Get the real IP address
     *
     * @return    string    IP address
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
            $pos = strrpos((string) $ip, '.');
            $ip = substr((string) $ip, 0, $pos) . '.0';
        }
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     * action getFeUser
     */
    public function getFeUser(int $userid): array
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('fe_users');
        $queryBuilder = $connection->createQueryBuilder();
        $statement = $queryBuilder->select('*')->from('fe_users')->where(
            $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($userid, \PDO::PARAM_INT))
        )->setMaxResults(1)->executeQuery();
        while ($row = $statement->fetch()) {
            return $row;
        }
        return [];
    }

    /**
     * Set all user-answers to a question
     *
     * @param Question $oneQuestion The question dataset
     * @return string
     */
    protected function setAllUserAnswersForOneQuestion(Question &$oneQuestion, int $pid, bool $be)
    {
        $votes = 0;
        $votesTotal = 0;
        $debug = '';
        $allResults = [];
        //$allCategoryResults = [];
        $questionID = $oneQuestion->getUid();
        $isEnterQuestion = (($oneQuestion->getQmode() == 3) || ($oneQuestion->getQmode() == 5));
        if ($this->settings['debug']) {
            $debug .= "\nquestion :" . $questionID;
        }
        if ($be) {
            $allAnsweredQuestions = $this->selectedRepository->findFromPidAndQuestion($pid, $questionID);
        } else {
            $allAnsweredQuestions = $this->selectedRepository->findBy(['question' => $questionID]);
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
                    if (isset($allResults[$oneAnswer->getUid()])) {
                        $allResults[$oneAnswer->getUid()]++;
                    } else {
                        $allResults[$oneAnswer->getUid()] = 1;
                    }
                    /* TODO:
                    if ($oneQuestion->getQmode() == 8) {
                        // ausgewählte Kategorien einer Antwort
                        $catAnswers = unserialize($aSelectedQuestion->getEntered());
                        foreach ($catAnswers as $key => $value) {
                            if (!is_array($allCategoryResults[$key])) {
                                $allCategoryResults[$key] = [];
                            }
                            if (isset($allCategoryResults[$key][$value])) {
                                $allCategoryResults[$key][$value]++;
                            } else {
                                $allCategoryResults[$key][$value] = 1;
                            }
                        }
                    }
                    */
                } else if ($be) {
                    // Text-Antworten anderer interessieren uns nur im Backend
                    if (isset($allResults['text'])) {
                        if (!is_array($allResults['text'])) {
                            $allResults['text'] = [];
                        }
                        if (isset($allResults['text'][$aSelectedQuestion->getEntered()])) {
                            if (!is_array($allResults['text'][$aSelectedQuestion->getEntered()])) {
                                $allResults['text'][$aSelectedQuestion->getEntered()] = [];
                            }
                            if (isset($allResults['text'][$aSelectedQuestion->getEntered()]['sum'])) {
                                $allResults['text'][$aSelectedQuestion->getEntered()]['sum']++;
                            } else {
                                $allResults['text'][$aSelectedQuestion->getEntered()]['sum'] = 1;
                            }
                        }
                    } else {
                        $allResults['text'] = [];
                    }
                }
            }
        }
        // gesammeltes speichern bei: alle möglichen Antworten einer Frage...
        foreach ($oneQuestion->getAnswers() as $oneAnswer) {
            $thisVotes = isset($allResults[$oneAnswer->getUid()]) ? intval($allResults[$oneAnswer->getUid()]) : 0;
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
        // ... und Prozentwerte speichern
        foreach ($oneQuestion->getAnswers() as $oneAnswer) {
            $thisVotes = isset($allResults[$oneAnswer->getUid()]) ? intval($allResults[$oneAnswer->getUid()]) : 0;
            $percentage = 0;
            if ($votes) {
                $percentage = 100 * ($thisVotes / $votes);
            }
            $oneAnswer->setAllPercent($percentage);
            $percentage = 0;
            if ($votesTotal) {
                $percentage = 100 * ($thisVotes / $votesTotal);
            }
            if ($this->settings['debug'] && $votes) {
                $debug .= "\n percent: 100*" . $thisVotes . '/' . $votes . ' = ' . 100 * ($thisVotes / $votes);
                $debug .= "\n total percent: 100*" . $thisVotes . '/' . $votesTotal . ' = ' . $percentage;
            }
            $oneAnswer->setTotalPercent($percentage);
        }
        $oneQuestion->setAllAnswers($votes);
        $oneQuestion->setTotalAnswers($votesTotal);
    }

    /**
     * Set all user-answers to a quiz
     *
     * @param Quiz $c_quiz The Quiz dataset
     * @return string
     */
    protected function setAllUserAnswers(Quiz &$c_quiz, int $pid, bool $be)
    {
        $debug = '';
        foreach ($c_quiz->getQuestions() as $oneQuestion) {
            $debug .= $this->setAllUserAnswersForOneQuestion($oneQuestion, $pid, $be);
        }
        return $debug;
    }

    /**
     * Set all metatags
     *
     * @param Quiz $c_quiz The Quiz dataset
     * @return void
     */
    protected function setMetatags(Quiz &$c_quiz)
    {
        $title = $c_quiz->getName();
        $GLOBALS['TSFE']->page['title'] = $title;
        $metaTagManager = GeneralUtility::makeInstance( MetaTagManagerRegistry::class);
        $description = str_replace(["\r", "\n"], " ", $c_quiz->getAbout());
        $description = str_replace("  ", " ", $description);
        $meta = $metaTagManager->getManagerForProperty('description');
        $meta->addProperty('description', $description);
        $meta = $metaTagManager->getManagerForProperty('og:description');
        $meta->addProperty('og:description', $description);
        $meta = $metaTagManager->getManagerForProperty('og:title');
        $meta->addProperty('og:title', $title);
    }

    /**
     * Checks if a quiz is allowed
     *
     * @return boolean
     */
    public function checkQuizAccess(int $pid, int $uid): bool
    {
        $storagePidsArray = $this->quizRepository->getStoragePids();
        if (is_array($storagePidsArray) && !$storagePidsArray[0] == 0) {
            if (!in_array($pid, $storagePidsArray)) {
                $this->addFlashMessage(
                    LocalizationUtility::translate('error.quizNotFound', 'fp_masterquiz') . ' pid=' . intval($pid),
                    LocalizationUtility::translate('error.error', 'fp_masterquiz'),
                    ContextualFeedbackSeverity::WARNING,
                    false
                );
                return false;
            }
        }
        $defaultQuizUid = $this->getLocalizedDefaultQuiz();
        if ($defaultQuizUid && $uid != $defaultQuizUid) {
            $this->addFlashMessage(
                LocalizationUtility::translate('error.quizNotAllowed', 'fp_masterquiz') . ' uid=' . intval($uid) .
                '<>' .$defaultQuizUid .', pid=' . intval($pid),
                LocalizationUtility::translate('error.error', 'fp_masterquiz'),
                ContextualFeedbackSeverity::WARNING,
                false
            );
            return false;
        }
        return true;
    }


    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $quizzes = $this->quizRepository->findAll();
        if ($this->request->hasArgument('action') && $this->request->getArgument('action')) {
            $targetAction = $this->request->getArgument('action');
        } else {
            $targetAction = 'show';
        }
        $this->view->assign('quizzes', $quizzes);
        $this->view->assign('targetAction', $targetAction);
        return $this->htmlResponse();
    }

    /**
     * action intro
     *
     * @return ResponseInterface
     */
    public function introAction(): ResponseInterface
    {
        if ($this->settings['introContentUid'] > 0) {
            $ttContentConfig = ['tables' => 'tt_content', 'source' => $this->settings['introContentUid'], 'dontCheckPid' => 1];
            $contentElement = $GLOBALS['TSFE']->cObj->cObjGetSingle('RECORDS', $ttContentConfig);
        } else {
            $contentElement = '';
        }
        $defaultQuizUid = $this->getLocalizedDefaultQuiz();
        if ($defaultQuizUid) {
            $quiz = $this->quizRepository->findOneBy(['uid' => $defaultQuizUid]);
            if ($quiz) {
                $this->view->assign('quiz', $quiz);
            } else {
                $this->view->assign('quiz', 0);
                $this->addFlashMessage(
                    LocalizationUtility::translate('error.quizNotFound', 'fp_masterquiz') . ' ' . $defaultQuizUid,
                    LocalizationUtility::translate('error.error', 'fp_masterquiz'),
                    ContextualFeedbackSeverity::WARNING,
                    false
                );
            }
        } else {
            $this->view->assign('quiz', 0);
        }
        $uidOfCE = 0;
        if (isset($this->configurationManager->getContentObject()->data['uid'])) {
            $uidOfCE = $this->configurationManager->getContentObject()->data['uid'];
        }
        $this->view->assign('action', 'show');
        $this->view->assign('uidOfCE', $uidOfCE);
        $this->view->assign('uidOfPage', $GLOBALS['TSFE']->id);
        $this->view->assign('contentElement', $contentElement);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz||null $quiz
     * @return ResponseInterface
     */
    public function showAction(Quiz $quiz = null): ResponseInterface
    {
        if (!$quiz) {
            $quiz = $this->getDefaultQuiz();
            if (!$quiz) {
                return (new ForwardResponse('list'))
                    ->withArguments(['action' => 'show']);
            }
        }
        if (!$this->checkQuizAccess($quiz->getPid(), $quiz->getLocalizedUid())) {
            return $this->htmlResponse();
        }
        if ($this->checkForClosure()) {
            $uri = $this->uriBuilder->reset()
                ->setTargetPageUid($this->settings['closurePageUid'])
                ->uriFor(
                    'closure',
                    [
                        'participant' => $this->participant,
                        'session' => $this->participant->getSession()
                    ],
                    'Quiz',
                    null,
                    'closure'
                );
            return $this->responseFactory->createResponse(307)
                ->withHeader('Location', $uri);
        }
        // participant wird zuerst hier definiert ...
        $userData = $this->findParticipant($quiz->getUid(), $quiz->getPid());
        /// ... und dann hier in der DB abgespeichert
        $data = $this->doAll($quiz, $userData, 0, []);
        if ($data['redirectTo']) {
            return $this->responseFactory->createResponse(307)
                ->withHeader('Location', $data['redirectTo']);
        }
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
        $quizPaginator = new ArrayPaginator($questionsArray, $page, intval($this->settings['pagebrowser']['itemsPerPage']));
        $participantPaginator = new ArrayPaginator($participantArray, $page, intval($this->settings['pagebrowser']['itemsPerPage']));

        if ($this->settings['groupByTag']) {
            // in diesem Fall brauchen wir das letzte und nächste Tag
            $lastItem = null;
            $lastTag = '';
            foreach ($quizPaginator->getPaginatedItems() as $itemQuestion) {
                if ($lastItem) {
                    $lastItem->setNextTag($itemQuestion->getTag()->getName());
                }
                if (($lastTag)) {
                    $itemQuestion->setPrevTag($lastTag);
                }
                $lastTag = $itemQuestion->getTag()->getName();
                $lastItem = $itemQuestion;
            }
        }

        $this->view->assign('quiz', $quiz);
        $this->view->assign('quizPaginator', $quizPaginator);
        $this->view->assign('participant', $this->participant);
        $this->view->assign('participantPaginator', $participantPaginator);
        if ($pages > 0) {
            $this->view->assign('pagePercent', intval(round(100 * ($page / $pages))));
            $this->view->assign('pagePercentInclFinalPage', intval(round(100 * ($page / ($pages + 1)))));
        }
        foreach ($data as $key => $value) {
            $this->view->assign($key, $value);
        }
        $uidOfCE = 0;
        if (isset($this->configurationManager->getContentObject()->data['uid'])) {
            $uidOfCE = $this->configurationManager->getContentObject()->data['uid'];
        }
        $this->view->assign('pagesInclFinalPage', ($pages + 1));
        $this->view->assign('pageBasis', ($page - 1) * $this->settings['pagebrowser']['itemsPerPage']);
        $this->view->assign("sysLanguageUid", $sys_language_uid);
        $this->view->assign('uidOfPage', $GLOBALS['TSFE']->id);
        $this->view->assign('uidOfCE', $uidOfCE);
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
        if (intval($this->settings['debug'])==2 && $data['debug']) {
            $this->logger->debug($data['debug']);
        }
        return $this->htmlResponse();
    }

    /**
     * action showByTag
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz||null $quiz
     * @return ResponseInterface
     */
    public function showByTagAction(Quiz $quiz = null): ResponseInterface
    {
        if (!$quiz) {
            $quiz = $this->getDefaultQuiz();
            if (!$quiz) {
                return (new ForwardResponse('list'))
                    ->withArguments(['action' => 'showByTag']);
            }
        }
        if (!$this->checkQuizAccess($quiz->getPid(), $quiz->getLocalizedUid())) {
            return $this->htmlResponse();
        }
        if ($this->checkForClosure()) {
            $uri = $this->uriBuilder->reset()
                ->setTargetPageUid($this->settings['closurePageUid'])
                ->uriFor(
                    'closure',
                    [
                        'participant' => $this->participant,
                        'session' => $this->participant->getSession()
                    ],
                    'Quiz',
                    null,
                    'closure'
                );
            return $this->responseFactory->createResponse(307)
                ->withHeader('Location', $uri);
        }
        $userData = $this->findParticipant($quiz->getUid(), $quiz->getPid());
        $page = $this->request->hasArgument('currentPage') ? intval($this->request->getArgument('currentPage')) : 1;
        // Suche Fragen passend zu einer Seite (jeweils nur 1 Tag verwendet)
        $tagArray = $quiz->getQuestionsSortByTag($page, $this->settings['random'], $this->participant->getRandompages());
        $tag = '';
        if (isset($tagArray['pagetags'][$page])) {
            $tag = $tagArray['pagetags'][$page];
        }
        $pages = $tagArray['pages'];
        $data = $this->doAll($quiz, $userData, $pages, $tagArray['randomNumbers']);
        if ($data['redirectTo']) {
            return $this->responseFactory->createResponse(307)
                ->withHeader('Location', $data['redirectTo']);
        }
        $lastPage = $data['lastPage'];
        if ($this->settings['allowEdit']) {
            $lastPage = $page;
        }
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        if ($this->settings['setMetatags']) {
            $this->setMetatags($quiz);
        }
        $tagSelections = [];
        if (($lastPage > 0) && ($data['showAnswers'] || $this->settings['allowEdit']) && (isset($tagArray['pagetags'][$lastPage]))) {
            // Antworten vom user suchen
            $tagSelections = $this->participant->getSelectionsByTag($tagArray['pagetags'][$lastPage]);
        }
        if ($this->settings['debug']) {
            $data['debug'] .= "\nTag=$tag; page=$page; pages=$pages; random page order: " . implode(',', $tagArray['randomNumbers']);
        }
        if ($this->settings['allowEdit']) {
            $answeredQuestions = [];
            // eigene Antworten holen
            foreach ($tagSelections as $selection) {
                $quid = $selection->getQuestion()->getUid();
                $answeredQuestions[$quid] = [];
                $answeredQuestions[$quid]['text'] = [];
                $answeredQuestions[$quid]['check'] = [];
                $answeredQuestions[$quid]['text'][0] = $selection->getEntered();
                foreach ($selection->getAnswers() as $answer) {
                    $answeredQuestions[$quid]['check'][$answer->getTitle()] = 1;
                }
            }
            // eigene Antworten setzen
            foreach ($tagArray['questions'] as $question) {
                $quid = $question->getUid();
                if (isset($answeredQuestions[$quid])) {
                    if (is_array($answeredQuestions[$quid]['text'])) {
                        $question->setTextAnswers($answeredQuestions[$quid]['text']);
                    }
                    foreach ($question->getAnswers() as $answer) {
                        if (isset($answeredQuestions[$quid]['check'][$answer->getTitle()])) {
                            $checked = ($answeredQuestions[$quid]['check'][$answer->getTitle()]) ? 1 : 0;
                        } else {
                            $checked = 0;
                        }
                        $answer->setOwnAnswer($checked);
                    }
                }
            }
        }

        $this->view->assign('quiz', $quiz);
        $this->view->assign('tag', $tag);
        $this->view->assign('tags', $tagArray['pagetags']);
        $this->view->assign('tagQuestions', $tagArray['questions']);
        $this->view->assign('tagSelections', $tagSelections);
        $this->view->assign('randomPages', implode(',', $tagArray['randomNumbers']));
        $this->view->assign('participant', $this->participant);
        if ($pages > 0) {
            $this->view->assign('pagePercent', intval(round(100 * ($page / $pages))));
            $this->view->assign('pagePercentInclFinalPage', intval(round(100 * ($page / ($pages + 1)))));
        }
        foreach ($data as $key => $value) {
            $this->view->assign($key, $value);
        }
        $uidOfCE = 0;
        if (isset($this->configurationManager->getContentObject()->data['uid'])) {
            $uidOfCE = $this->configurationManager->getContentObject()->data['uid'];
        }
        $this->view->assign('pagesInclFinalPage', ($pages + 1));
        $this->view->assign('pageBasis', 0);
        $this->view->assign("sysLanguageUid", $sys_language_uid);
        $this->view->assign('uidOfPage', $GLOBALS['TSFE']->id);
        $this->view->assign('uidOfCE', $uidOfCE);
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
        if (intval($this->settings['debug'])==2 && $data['debug']) {
            $this->logger->debug($data['debug']);
        }
        return $this->htmlResponse();
    }

    /**
     * action showAjax. So könnte es vielleicht auch gehen: at dontverifyrequesthash
     *
     * @return ResponseInterface
     */
    public function showAjaxAction(Quiz $quiz): ResponseInterface
    {
        if (!$this->checkQuizAccess($quiz->getPid(), $quiz->getLocalizedUid())) {
            return $this->htmlResponse();
        }
        if ($this->checkForClosure()) {
            $uri = $this->uriBuilder->reset()
                ->setTargetPageUid($this->settings['closurePageUid'])
                ->uriFor(
                    'closure',
                    [
                        'participant' => $this->participant,
                        'session' => $this->participant->getSession()
                    ],
                    'Quiz',
                    null,
                    'closure'
                );
            return $this->responseFactory->createResponse(307)
                ->withHeader('Location', $uri);
        }
        // siehe: https://www.sebkln.de/tutorials/erstellung-einer-typo3-extension-mit-ajax-aufruf/
        //	$quizUid = $this->request->hasArgument('quiz') ? intval($this->request->getArgument('quiz')) : 0;
        //		$quiz = $this->quizRepository->findOneByUid($quizUid);
        // vorerst mal
        $this->settings['user']['useCookie'] = 0;
        $userData = $this->findParticipant($quiz->getUid(), $quiz->getPid());
        $data = $this->doAll($quiz, $userData, 0, []);
        if ($data['redirectTo']) {
            return $this->responseFactory->createResponse(307)
                ->withHeader('Location', $data['redirectTo']);
        }
        $page = $data['page'];
        $pages = $data['pages'];
        $from = 1 + (($page - 1) * intval($this->settings['pagebrowser']['itemsPerPage']));
        $to = ($page * intval($this->settings['pagebrowser']['itemsPerPage']));
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();

        if ($data['useJoker'] == 1) {
            // Joker-Antworten hier automatisch setzen
            if ($this->settings['debug']) {
                $data['debug'] .= "\nJoker was used. Setting automatic joker answers: ";
            }
            $i = 0;
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
                    $jokerHalf = intval(ceil($jokerMax / 2));   // aus 5 wird 3, aus 4 wird 2
                    $jokerFehlend = $jokerHalf - $jokerSet;   // 3-1=2; 2-1=1 bei 1 richtigen Antwort
                    // Schritt 2: # fehlende Joker auf 0 (richtig) setzen
                    foreach ($question->getAnswers() as $answer) {
                        if ($jokerFehlend && ($answer->getJokerAnswer() == 1)) {
                            $random = random_int($jokerSet + 1, $jokerMax);     // 2 bis 5 (1/4) bzw. 2 bis 4 (1/3)
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
            $this->view->assign('pagePercent', intval(round(100 * ($page / $pages))));
            $this->view->assign('pagePercentInclFinalPage', intval(round(100 * ($page / ($pages + 1)))));
        }
        $this->view->assign('nextPage', $data['nextPage']);
        $this->view->assign('pages', $pages);
        $this->view->assign('pagesInclFinalPage', ($pages + 1));
        $this->view->assign('questions', $data['questions']);
        $this->view->assign('pageBasis', ($page - 1) * $this->settings['pagebrowser']['itemsPerPage']);
        $this->view->assign('final', $data['final']);
        $this->view->assign('finalContent', $data['finalContent']);
        $this->view->assign('finalCategories', $data['finalCategories']);
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
        if (intval($this->settings['debug'])==2 && $data['debug']) {
            $this->logger->debug($data['debug']);
        }
        return $this->htmlResponse();
    }

    /**
     * action result
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz||null $quiz
     * @return ResponseInterface
     */
    public function resultAction(Quiz $quiz = null): ResponseInterface
    {
        if (!$quiz) {
            $quiz = $this->getDefaultQuiz();
            if (!$quiz) {
                return (new ForwardResponse('list'))
                    ->withArguments(['action' => 'result']);
            }
        }
        if (!$this->checkQuizAccess($quiz->getPid(), $quiz->getLocalizedUid())) {
            return $this->htmlResponse();
        }
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $pid = (int)$GLOBALS['TSFE']->id;
        $uidOfCE = 0;
        if (isset($this->configurationManager->getContentObject()->data['uid'])) {
            $uidOfCE = $this->configurationManager->getContentObject()->data['uid'];
        }
        $debug = $this->setAllUserAnswers($quiz, $pid, false);
        if ($this->settings['user']['useQuizPid']) {
            $userPid = $quiz->getPid();
        } else {
            $storagePidsArray = $this->quizRepository->getStoragePids();
            if (is_array($storagePidsArray) && !$storagePidsArray[0] == 0) {
                $userPid = $storagePidsArray[0];
            } else {
                $userPid = $pid;
            }
        }
        $this->view->assign('quiz', $quiz);
        $this->view->assign('participants', $this->participantRepository->findFromPidAndQuiz($userPid, $quiz->getUid(), $this->settings['resultLimit']));
        $this->view->assign('debug', $debug);
        $this->view->assign("sysLanguageUid", $sys_language_uid);
        $this->view->assign('uidOfPage', $pid);
        $this->view->assign('uidOfCE', $uidOfCE);
        if (intval($this->settings['debug'])==2 && $debug) {
            $this->logger->debug($debug);
        }
        return $this->htmlResponse();
    }

    /**
     * action highscore
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz||null $quiz
     * @return ResponseInterface
     */
    public function highscoreAction(Quiz $quiz = null): ResponseInterface
    {
        if (!$quiz) {
            $quiz = $this->getDefaultQuiz();
            if (!$quiz) {
                return (new ForwardResponse('list'))
                    ->withArguments(['action' => 'highscore']);
            }
        }
        if (!$this->checkQuizAccess($quiz->getPid(), $quiz->getLocalizedUid())) {
            return $this->htmlResponse();
        }
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $pid = (int)$GLOBALS['TSFE']->id;
        $participants = $this->participantRepository->findFromQuizLimit($quiz->getUid(), intval($this->settings['highscoreLimit']));
        $uidOfCE = 0;
        if (isset($this->configurationManager->getContentObject()->data['uid'])) {
            $uidOfCE = $this->configurationManager->getContentObject()->data['uid'];
        }
        $this->view->assign('quiz', $quiz);
        $this->view->assign('participants', $participants);
        $this->view->assign("sysLanguageUid", $sys_language_uid);
        $this->view->assign('uidOfPage', $pid);
        $this->view->assign('uidOfCE', $uidOfCE);
        return $this->htmlResponse();
    }

    /**
     * action closure: show only text and links
     *
     * @return ResponseInterface
     */
    public function closureAction(Participant $participant, string $session = ''): ResponseInterface
    {
        if ($participant->getSession() == $session) {
            $this->view->assign('participant', $participant);
            $this->view->assign('quiz', $participant->getQuiz());
        } else {
            $this->addFlashMessage(
                LocalizationUtility::translate('error.invalidParameters', 'fp_masterquiz'),
                LocalizationUtility::translate('error.error', 'fp_masterquiz'),
                ContextualFeedbackSeverity::WARNING,
                false
            );
        }
        return $this->htmlResponse();
    }


    /**
     * Action index for the backend
     *
     * @return ResponseInterface
     */
    function indexAction(): ResponseInterface
    {
        $otherLangs = [];
        $pid = (int)GeneralUtility::_GP('id');
        $quizzes = $this->quizRepository->findFromPid($pid);
        foreach ($quizzes as $quiz) {
            $otherLangs[] = $this->quizRepository->findFormUidAndPidOtherLanguages($quiz->getUid());
        }
        $this->view->assign('pid', $pid);
        $this->view->assign('quizzes', $quizzes);
        $this->view->assign('otherQuizzes', $otherLangs);
        $this->addDocHeaderDropDown('index');
        return $this->defaultRendering();
    }

    /**
     * action show for the backend
     *
     * @return ResponseInterface
     */
    public function detailAction(Quiz $quiz): ResponseInterface
    {
        $questionRepository = GeneralUtility::makeInstance(QuestionRepository::class);
        $pid = (int)GeneralUtility::_GP('id');
        $uid = (int)$quiz->getUid();
        $updated = false;
        $lost = $this->request->hasArgument('lost') ? intval($this->request->getArgument('lost')) : 0;
        if ($lost > 0) {
            // wir fügen erst eine verschollene Frage ohne Referenz hinzu
            $question2 = $questionRepository->findbyUid($lost);
            $quiz->addQuestion($question2);
            $this->quizRepository->update($quiz);
            $this->persistenceManager->persistAll();
            $updated = true;
            $this->addFlashMessage(
                LocalizationUtility::translate('text.questionAdded', 'fp_masterquiz'),
                LocalizationUtility::translate('text.updated', 'fp_masterquiz'),
                ContextualFeedbackSeverity::OK,
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
        $this->addDocHeaderDropDown('index');
        return $this->defaultRendering();
    }

    /**
     * action charts for the backend
     *
     * @return ResponseInterface
     */
    public function chartsAction(Quiz $quiz): ResponseInterface
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
        $this->addDocHeaderDropDown('index');
        return $this->defaultRendering();
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
    protected function sendTemplateEmail(array $recipient, array $sender, $subject, $templateName, array $variables = [], $toAdmin = false): bool
    {
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );

        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $emailView */
        $emailViewHtml = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
        $emailViewHtml->setTemplateRootPaths($extbaseFrameworkConfiguration['view']['templateRootPaths']);
        $emailViewHtml->setLayoutRootPaths($extbaseFrameworkConfiguration['view']['layoutRootPaths']);
        $emailViewHtml->setPartialRootPaths($extbaseFrameworkConfiguration['view']['partialRootPaths']);
        $emailViewHtml->setTemplate('Email/' . $templateName . '.html');
        $emailViewHtml->setFormat('html');
        $emailViewHtml->assignMultiple($variables);
        $emailBodyHtml = $emailViewHtml->render();
        if ($this->settings['debug']) {
            echo "###" . $emailBodyHtml . '###';
            return true;
        }

        /** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
        $message = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
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


    /*
    * Fürs Backend-Modul
    */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    protected function defaultRendering(): ResponseInterface
    {
        $this->moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($this->moduleTemplate->renderContent());
    }

    protected function addDocHeaderDropDown(string $currentAction): void
    {
        $languageService = $this->getLanguageService();
        $actionMenu = $this->moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $actionMenu->setIdentifier('masterquizSelector');
        $actions = ['Quiz,index', 'Participant,list'];
        foreach ($actions as $controller_action_string) {
            $controller_action_array = explode(",", $controller_action_string);
            $actionMenu->addMenuItem(
                $actionMenu->makeMenuItem()
                    ->setTitle($languageService->sL(
                        'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_mod1.xlf:index.' .
                        strtolower($controller_action_array[0])
                    ))
                    ->setHref($this->getModuleUri($controller_action_array[0], $controller_action_array[1]))
                    ->setActive($currentAction === $controller_action_array[1])
            );
        }
        $this->moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->addMenu($actionMenu);
    }

    protected function getModuleUri(string $controller = null, string $action = null): string
    {
        return $this->uriBuilder->reset()->uriFor($action, null, $controller, 'mod1');
    }
}
