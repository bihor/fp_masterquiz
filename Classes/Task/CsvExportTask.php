<?php
namespace Fixpunkt\FpMasterquiz\Task;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

class CsvExportTask extends AbstractTask
{

    /**
     * CSV file
     *
     * @var string
     */
    protected $csvfile;

    /**
     * Uid of the folder
     *
     * @var integer
     */
    protected $page = 0;

    /**
     * Separator
     *
     * @var string
     */
    protected $separator;

    /**
     * Delimiter
     *
     * @var string
     */
    protected $delimiter;

    /**
     * Answers-Delimiter
     *
     * @var string
     */
    protected $ansdelimiter;

    /**
     * Convert from UTF-8 to ISO?
     *
     * @var integer
     */
    protected $convert = 0;

    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * Get the value of the csv file
     *
     * @return string
     */
    public function getCsvfile() {
        return $this->csvfile;
    }

    /**
     * Set the value of the private property csvfile.
     *
     * @param string $csvfile Path to the csv file
     * @return void
     */
    public function setCsvfile($csvfile) {
        $this->csvfile = $csvfile;
    }

    /**
     * Get the value of the protected property page
     *
     * @return integer UID of the start page for this task
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Set the value of the private property page
     *
     * @param integer $page UID of the start page for this task.
     * @return void
     */
    public function setPage($page) {
        $this->page = $page;
    }

    /**
     * Get the separator
     *
     * @return string
     */
    public function getSeparator() {
        return $this->separator;
    }

    /**
     * Set the value of the separator
     *
     * @param string $separator
     * @return void
     */
    public function setSeparator($separator) {
        $this->separator = $separator;
    }

    /**
     * Get the delimiter
     *
     * @return string
     */
    public function getDelimiter() {
        return $this->delimiter;
    }

    /**
     * Set the value of the delimiter
     *
     * @param string $delimiter
     * @return void
     */
    public function setDelimiter($delimiter) {
        $this->delimiter = $delimiter;
    }

    /**
     * Get the ansdelimiter
     *
     * @return string
     */
    public function getAnswersDelimiter() {
        return $this->ansdelimiter;
    }

    /**
     * Set the value of the ansdelimiter
     *
     * @param string $ansdelimiter
     * @return void
     */
    public function setAnswersDelimiter($ansdelimiter) {
        $this->ansdelimiter = $ansdelimiter;
    }

    /**
     * Get the value of the protected property convert
     *
     * @return integer
     */
    public function getConvert() {
        return $this->convert;
    }

    /**
     * Set the value of the private property convert
     *
     * @param integer $convert
     * @return void
     */
    public function setConvert($convert) {
        $this->convert = ($convert) ? 1 : 0;
    }


    public function execute(): bool
    {
        $successfullyExecuted = true;
        $ln = "\r\n";							// line break
        $uid = (int) $this->getPage();			// folder with quiz elements
        $fieldArray = ['uid', 'sys_language_uid', 'crdate', 'name', 'email', 'homepage', 'qname', 'qtitle', 'atitle', 'entered', 'spoints', 'ppoints', 'maximum1', 'maximum2'];
        $separator = $this->getSeparator();		// Texttrenner
        $delimiter = $this->getDelimiter();		// Feldtrenner
        $answersDelimiter = $this->getAnswersDelimiter();	// Feldtrenner bei Kategorien
        $convert = (bool) $this->getConvert();	// convert from UTF-8 to ASCII?
        $text = $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant.sys_language_uid').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant.crdate').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant.name').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant.email').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant.homepage').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_quiz').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_question').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_answer').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_selected.entered').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_selected.points').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant.points').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant.maximum1').$separator.$delimiter.
            $separator.$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang.xlf:tx_fpmasterquiz_domain_model_participant.maximum2').$separator.$delimiter;
        if ($convert) {
            $text = iconv('utf-8', 'iso-8859-1', $text);
        }

        $content = $text . $ln;					// header of the csv file
        $i = 0;									// Counter
        $mmArray = [];
        $text = '';

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_answer');
        $result = $queryBuilder
            ->select('title', 'points', 'uid_local', 'uid_foreign')
            ->from('tx_fpmasterquiz_domain_model_answer')
            ->join(
                'tx_fpmasterquiz_domain_model_answer',
                'tx_fpmasterquiz_selected_answer_mm',
                'mm',
                $queryBuilder->expr()->eq('mm.uid_foreign', $queryBuilder->quoteIdentifier('tx_fpmasterquiz_domain_model_answer.uid'))
            )
            ->where(
                $queryBuilder->expr()->eq('tx_fpmasterquiz_domain_model_answer.pid', $uid)
            )
            ->orderBy('mm.sorting', 'ASC')
            ->executeQuery()->fetchAllAssociative();
        //echo $queryBuilder->getSQL();
        foreach ($result as $row) {
            if (isset($mmArray[$row['uid_local']])) {
                $mmArray[$row['uid_local']] .= $answersDelimiter . $row['title'];
            } else {
                $mmArray[$row['uid_local']] = $row['title'];
            }
        }
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_participant');
        $result = $queryBuilder
            ->select('tx_fpmasterquiz_domain_model_selected.uid AS suid', 'quiz.name AS qname', 'question.title AS qtitle',
                'question.qmode', 'tx_fpmasterquiz_domain_model_selected.points AS spoints', 'tx_fpmasterquiz_domain_model_selected.entered',
                'part.uid', 'part.name', 'email', 'homepage', 'part.points AS ppoints', 'part.maximum1', 'part.maximum2',
                'part.sys_language_uid', 'part.crdate')
            ->from('tx_fpmasterquiz_domain_model_selected')
            ->join(
                'tx_fpmasterquiz_domain_model_selected',
                'tx_fpmasterquiz_domain_model_participant',
                'part',
                $queryBuilder->expr()->eq('part.uid', $queryBuilder->quoteIdentifier('tx_fpmasterquiz_domain_model_selected.participant'))
            )
            ->join(
                'part',
                'tx_fpmasterquiz_domain_model_quiz',
                'quiz',
                $queryBuilder->expr()->eq('quiz.uid', $queryBuilder->quoteIdentifier('part.quiz'))
            )
            ->join(
                'tx_fpmasterquiz_domain_model_selected',
                'tx_fpmasterquiz_domain_model_question',
                'question',
                $queryBuilder->expr()->eq('question.uid', $queryBuilder->quoteIdentifier('tx_fpmasterquiz_domain_model_selected.question'))
            )
            ->where(
                $queryBuilder->expr()->eq('tx_fpmasterquiz_domain_model_selected.pid', $queryBuilder->createNamedParameter($uid, \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
            )
            ->orderBy('part.uid', 'DESC')
            ->addOrderBy('suid', 'ASC')
            ->executeQuery()->fetchAllAssociative();
        //echo $queryBuilder->getSQL();
        foreach ($result as $row) {

            if ($i > 0) {
                $content .= $ln;
            }

            $j = 0;
            foreach ($fieldArray as $field) {
                if ($j>0) {
                    $content .= $delimiter;
                }

                if ($field === 'atitle') {
                    $text = (!isset($row['suid']) || !isset($mmArray[$row['suid']]) || $row['qmode'] == 3 || $row['qmode'] == 5 || $row['qmode'] == 6) ? '' : $mmArray[$row['suid']];
                } elseif (isset($row[trim($field)])) {
                    $text = $row[trim($field)];
                } else {
                    $text = '';
                }

                $text = preg_replace( "/\r|\n/", " ", (string) $text);
                if ($convert) {
                    $text = iconv('utf-8', 'iso-8859-1', $text);
                }

                if ($field === 'crdate') {
                    $text = date("d.m.Y H:i", intval($text));
                } elseif ($separator) {
                    $text = str_replace($separator, '', $text);
                }

                $content .= $separator . $text . $separator;
                $j++;
            }

            $i++;

        }

        $fp = fopen(Environment::getPublicPath() . '/' . $this->getCsvfile(), 'w');
        $ergebnis = fwrite($fp, $content);
        fclose($fp);
        if (!$ergebnis) {
            $successfullyExecuted = FALSE;
        }

        //echo "Anzahl exportiert: " . $i;
        return $successfullyExecuted;
    }
}
