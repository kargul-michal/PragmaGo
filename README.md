	# instalacja 

wykonujemy composer install w katalogu App

	# uruchamianie

z konsoli uruchamiamy komende  pragmago:merge
naprzyk³ad: php bin\console pragmago:merge var/tree.json var/list.json

	# komponent

Aby uruchomiæ us³ugê bez wykorzystywania komendy korzystamy z poni¿szego kodu

$mergeData = new App\Service\MergeData();
$fileLoader = new \App\Service\JsonLoader();

$treeData = $fileLoader->load( 'sciezka do pliku tree' );
$listData = $fileLoader->load( 'sciezka do pliku list' );
$listMap = new ListMap($listData);

$response = $this->mergeData->execute($treeData, $listMap);

zmienna $response zawiera drzewo obiektów \stdClass
serializacja do json echo json_encode($response);

	# uwagi 

W przypadku braku kategorii zwracany jest ci¹g znaków ListMap::PLACEHOLDER
