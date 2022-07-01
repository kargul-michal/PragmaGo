<?php
namespace App\Service;

use App\Exception\FileMissingException;
use App\Exception\FileReadException;
use App\Exception\FileWrongContentException;

/**
 * obiekt laduje dane z podanego pliku i parsuje do listy obiektów \stdClass
 *
 * @author MicKar
 *        
 */
class JsonLoader
{

    /**
     * obiekt laduje dane z podanego pliku i parsuje do listy obiektów \StdClass
     *
     * @param string $file
     *            sciezka do ładowanego pliku
     * @throws FileMissingException
     * @throws FileReadException
     * @throws FileWrongContentException
     * @return \stdClass[]
     */
    public function load(string $file): array {
        if (! file_exists($file)) {
            throw new FileMissingException("Szukany plik nie istnieje! " . $file);
        }

        $rawContent = file_get_contents($file);

        if (! $rawContent) {

            throw new FileReadException("Nie udało się wczytać danych z pliku lub plik jest pusty! " . $file);
        }

        $jsonData = json_decode($rawContent);

        if (! is_array($jsonData)) {
            throw new FileWrongContentException("Nie udało się wczytać danych z pliku lub plik jest pusty! " . $file);
        }

        return $jsonData; 
    }
}