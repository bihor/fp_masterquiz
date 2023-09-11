<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

final class FixImageReferencesUpgradeWizard implements UpgradeWizardInterface, RepeatableInterface
{
    /**
     * Return the identifier for this wizard
     * This should be the same string as used in the ext_localconf.php class registration
     */
    public function getIdentifier(): string
    {
        return 'fixImageReferencesFpQuiz';
    }

    /**
     * Return the speaking name of this wizard
     */
    public function getTitle(): string
    {
        return 'Fix image references for quizzes after update';
    }

    /**
     * Return the description for this wizard
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     */
    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_file_reference');

        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->update('sys_file_reference')
            ->set('fieldname', 'media')
            ->where(
                $queryBuilder->expr()->eq('tablenames',
                    $queryBuilder->createNamedParameter('tx_fpmasterquiz_domain_model_quiz')
                )
            )
            ->executeStatement();
        return true;
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool Whether an update is required (TRUE) or not (FALSE)
     */
    public function updateNecessary(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
        ->getConnectionForTable('sys_file_reference')
        ->createQueryBuilder();

        $queryBuilder->count('*')
            ->from('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq(
                    'tablenames',
                    $queryBuilder->createNamedParameter('tx_fpmasterquiz_domain_model_quiz')
                )
            )->andWhere(
                $queryBuilder->expr()->eq(
                    'fieldname',
                    $queryBuilder->createNamedParameter('image')
                )
            );

        return (int)$queryBuilder->executeQuery()->fetchOne() > 0;
    }

    /**
     * Returns an array of class names of prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }
}
