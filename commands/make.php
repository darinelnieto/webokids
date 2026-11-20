<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ditto\Functions;

require_once('ditto-functions.php');

class MakeTemplateCommand extends Command {
    protected $commandName = 'make:template';
    protected $commandDescription = "Make a WordPress Template";

    protected $commandArgumentName = "template name";
    protected $commandArgumentDescription = "What name will your template have?";

    protected function configure() {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output) {
        $templateName = $input->getArgument($this->commandArgumentName);
        $randomHash = bin2hex(random_bytes(3));

        if ($templateName) {
            
            $fileName = Functions\Convert::Slug($templateName).'-template';
            if(!is_file('templates/'.$fileName.'.php')){
                $contents = Functions\Content::Template($templateName, $randomHash);
                file_put_contents('templates/'.$fileName.'.php', $contents);
                $output->writeln($fileName.'.php created.');
                if(!is_file('sass/templates/'.$fileName.'.scss')){
                    file_put_contents('sass/templates/_'.$fileName.'.scss', '#'.Functions\Convert::Slug($templateName).'-template-'.$randomHash.' {}');
                    $mainSASS = file('sass/main.scss');
                    foreach ($mainSASS as $key => $line) {
                        if(strpos($line, '#DittoTemplates')) {
                            $mainSASS[$key] = '// #DittoTemplates'."\n".'@import "./templates/'.$fileName.'";'."\n";
                        }
                    }
                    file_put_contents('sass/main.scss', $mainSASS);
                    $output->writeln('sass/partials/_'.$fileName.'.scss created.');
                }
            } else {
                $output->writeln('The template already exists.');
            }
        } else {
            $output->writeln('Type the template name.');
        }
    }
}

class MakePartialCommand extends Command {
    protected $commandName = 'make:partial';
    protected $commandDescription = "Make a WordPress partial";

    protected $commandArgumentName = "partial name";
    protected $commandArgumentDescription = "What name will your partial have?";

    protected function configure() {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output) {
        $partialName = $input->getArgument($this->commandArgumentName);
        $randomHash = bin2hex(random_bytes(3));
        if ($partialName) {
            
            $fileName = str_replace(' ', '', $partialName);
            if(!is_file('partials/'.$fileName.'.php')){
                $contents = Functions\Content::Partial($partialName, $randomHash);
                file_put_contents('partials/'.$fileName.'.php', $contents);
                $output->writeln('partials/'.$fileName.'.php created.');
                if(!is_file('sass/partials/'.$fileName.'.scss')){
                    file_put_contents('sass/partials/_'.$fileName.'.scss', '.'.Functions\Convert::Slug($partialName).'-partial-'.$randomHash.' {}');
                    $mainSASS = file('sass/main.scss');
                    foreach ($mainSASS as $key => $line) {
                        if(strpos($line, '#DittoPartials')) {
                            $mainSASS[$key] = '// #DittoPartials'."\n".'@import "./partials/'.$fileName.'";'."\n";
                        }
                    }
                    file_put_contents('sass/main.scss', $mainSASS);
                    $output->writeln('sass/partials/_'.$fileName.'.scss created.');
                }
            } else {
                $output->writeln('The partial already exists.');
            }
        } else {
            $output->writeln('Type the partial name.');
        }
    }
}

class BuildPartialJsCommand extends Command {
    protected $commandName = 'build:partial-js';
    protected $commandDescription = "Minify js/partials/*.js into js/partials-min/*.min.js";

    protected $commandArgumentName = "partial name";
    protected $commandArgumentDescription = "Optional file name (without .js). If empty, all js/partials files are built.";

    protected function configure() {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $partialName = $input->getArgument($this->commandArgumentName);
        $jsFiles = array();

        if ($partialName) {
            $fileName = str_replace(array(' ', '.js'), '', $partialName);
            $sourceFile = 'js/partials/'.$fileName.'.js';
            if (!is_file($sourceFile)) {
                $output->writeln('The partial js file does not exist: '.$sourceFile);
                return 1;
            }
            $jsFiles[] = $sourceFile;
        } else {
            foreach ((array) glob('js/partials/*.js') as $file) {
                if (substr($file, -7) !== '.min.js') {
                    $jsFiles[] = $file;
                }
            }
        }

        if (empty($jsFiles)) {
            $output->writeln('No partial js files found to build.');
            return 1;
        }

        if (!is_dir('js/partials-min')) {
            mkdir('js/partials-min', 0777, true);
        }

        $failed = false;
        foreach ($jsFiles as $sourceFile) {
            $targetFile = 'js/partials-min/'.basename($sourceFile, '.js').'.min.js';
            $commandOutput = array();
            $command = 'npx terser '.escapeshellarg($sourceFile).' --compress --mangle --comments false --output '.escapeshellarg($targetFile).' 2>&1';
            exec($command, $commandOutput, $exitCode);

            if ($exitCode !== 0) {
                $failed = true;
                $output->writeln('Error building '.$sourceFile);
                $output->writeln(implode("\n", $commandOutput));
                continue;
            }

            $output->writeln($targetFile.' built.');
        }

        return $failed ? 1 : 0;
    }
}
