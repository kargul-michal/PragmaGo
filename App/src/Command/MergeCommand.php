<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Component\ListMap;

class MergeCommand extends Command
{

    const TREE_FILE_PATH_ARGUMENT = 'treeFilePath';

    const LIST_FILE_PATH_ARGUMENT = 'listFilePath';

    /**
     * obiekt łaczy dwie listy tree i list
     *
     * @var \App\Service\MergeData
     */
    protected $mergeData;

    /**
     * obiekt ładuje dane z plikow json
     *
     * @var \App\Service\JsonLoader
     */
    protected $fileLoader;

    protected static $defaultName = 'pragmago:merge';

    public function __construct(\App\Service\MergeData $mergeData, \App\Service\JsonLoader $fileLoader) {
        $this->mergeData = $mergeData;
        $this->fileLoader = $fileLoader;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $treeData = $this->fileLoader->load($input->getArgument(self::TREE_FILE_PATH_ARGUMENT));
        $listData = $this->fileLoader->load($input->getArgument(self::LIST_FILE_PATH_ARGUMENT));
        $listMap = new ListMap($listData);

        $response = $this->mergeData->execute($treeData, $listMap);

        echo json_encode($response);
        
        return Command::SUCCESS;
    }

    /**
     * parametry komendy
     */
    protected function configure(): void {
        $this->setDescription('Rekrutacja PragmaGo')->setHelp('PragmaGo połaczenie dwóch plików json:  tree i list')
            ->addArgument(self::TREE_FILE_PATH_ARGUMENT, InputArgument::REQUIRED, 'Sciezka do pliku tree.json')
            ->addArgument(self::LIST_FILE_PATH_ARGUMENT, InputArgument::REQUIRED, 'Sciezka do pliku list.json');
    }
}