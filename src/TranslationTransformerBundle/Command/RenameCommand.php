<?php

namespace SyliusBot\TranslationTransformerBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class RenameCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sylius-bot:translation-transformer:rename')
            ->addArgument('changelog-file', InputArgument::REQUIRED)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $translations = $this->getTranslations();
        $templates = $this->getTemplates();

        $mainCatalogue = $this->getTranslationsCatalogueWithMostKeys($translations);

        $renamingPairs = $this->getRenamingPairs($input->getArgument('changelog-file'), $mainCatalogue);
        foreach ($renamingPairs as $from => $to) {
            if ($from === $to) {
                continue;
            }

            echo "===> Renaming $from to $to...\n";

            foreach ($translations as $file => $values) {
                if (!isset($values[$from])) {
                    continue;
                }
                
                $translations[$file][$to] = $values[$from];
                unset($translations[$file][$from]);

                ksort($translations[$file]);
                
                echo "=> Affected translation file: " . $file . "\n";
            }

            foreach ($templates as $file => $content) {
                $count = 0;
                $templates[$file] = str_replace("'$from'|trans", "'$to'|trans", $content, $count);

                if (0 === $count) {
                    continue;
                }

                echo "=> Affected template file: " . $file . "\n";
            }
        }

        echo "===> Deflattening translations...\n";
        foreach ($translations as $file => $values) {
            $translations[$file] = $this->deflattenArray($values);
        }

        echo "===> Saving translations...\n";
        foreach ($translations as $file => $values) {
            file_put_contents($file, Yaml::dump($values, 666));
        }

        echo "===> Saving templates...\n";
        foreach ($templates as $file => $content) {
            file_put_contents($file, $content);
        }

        return;
    }

    /**
     * @param array $array
     * @param string $initialKey
     *
     * @return \Generator
     */
    private function flattenArray(array $array, $initialKey = '')
    {
        $output = [];

        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $output[$initialKey . $key] = $value;
                continue;
            }

            $output = array_merge(
                $output,
                $this->flattenArray($value, $initialKey . $key . '.')
            );
        }

        return $output;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function deflattenArray(array $array)
    {
        $output = [];
        foreach ($array as $key => $value) {
            $reference = &$output;

            $dots = explode('.', $key);
            foreach ($dots as $dot) {
                if (!isset($reference[$dot])) {
                    $reference[$dot] = [];
                }

                $reference = &$reference[$dot];
            }

            $reference = $value;
        }

        return $output;
    }

    /**
     * @return array
     */
    private function getTranslations()
    {
        $glob = glob('sources/src/Sylius/Bundle/WebBundle/Resources/translations/messages.*.yml');

        $translations = [];
        foreach ($glob as $translationFile) {
            $translations[$translationFile] = $this->flattenArray(Yaml::parse(file_get_contents($translationFile)));
        }

        return $translations;
    }

    /**
     * @return array
     */
    private function getTemplates()
    {
        $templates = [];

        /** @var SplFileInfo[] $templatesPaths */
        $templatesPaths = Finder::create()->in('sources/src/Sylius/Bundle')->name('*.html.twig');
        foreach ($templatesPaths as $templatePath) {
            $templates[$templatePath->getPathname()] = file_get_contents($templatePath->getPathname());
        }

        return $templates;
    }

    /**
     * @param string $changelogFile
     * @param array $mainCatalogue
     *
     * @return array
     */
    private function getRenamingPairs($changelogFile, array $mainCatalogue)
    {
        $replacePairs = [];
        $replaceCommands = file(__DIR__ . '/../../../' . $changelogFile);
        foreach ($replaceCommands as $replaceCommand) {
            $replaceCommand = trim($replaceCommand);
            if (empty($replaceCommand) || '#' === substr($replaceCommand, 0, 1)) {
                continue;
            }

            echo "---> Evaluating command: $replaceCommand\n";

            if (true === (bool) preg_match('/^RENAME (?P<from>[^\s]+) TO (?P<to>[a-z0-9\._]+)$/', $replaceCommand, $matches)) {
                $replacePairs[$matches['from']] = $matches['to'];
                continue;
            }

            if (true === (bool) preg_match('/^RENAME REGEXP (?P<regexp>.+) TO (?P<to>[a-z0-9\._]+)$/', $replaceCommand, $matches)) {
                foreach (array_keys($mainCatalogue) as $key) {
                    if (false === (bool) preg_match($matches['regexp'], $key, $nestedMatches)) {
                        continue;
                    }

                    echo "-> Created command: RENAME $key TO {$matches['to']}\n";
                    $replacePairs[$key] = $matches['to'];
                }
                continue;
            }

            if (true === (bool) preg_match('/^RENAME REGEXP (?P<regexp>.+) USING SLUGIFIED VALUE AS KEY$/', $replaceCommand, $matches)) {
                foreach ($mainCatalogue as $key => $value) {
                    if (false === (bool) preg_match($matches['regexp'], $key, $nestedMatches)) {
                        continue;
                    }

                    $keyFromValue = 'sylius.ui.' . str_replace(' ', '_', strtolower($value));

                    echo "-> Created command: RENAME $key TO $keyFromValue\n";
                    $replacePairs[$key] = $keyFromValue;
                }
                continue;
            }

            throw new \InvalidArgumentException('Cannot match ' . $replaceCommand);
        }

        return $replacePairs;
    }

    /**
     * @param array $translations
     *
     * @return array
     */
    private function getTranslationsCatalogueWithMostKeys($translations)
    {
        $mainCatalogue = [];
        foreach ($translations as $file => $values) {
            if (count($values) > count($mainCatalogue)) {
                $mainCatalogue = $values;
            }
        }

        return $mainCatalogue;
    }
}
