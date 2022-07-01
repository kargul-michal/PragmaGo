<?php
namespace App\Service;

use App\Component\ListMap;
use App\Exception\TypeException;

/**
 * metoda dodaje do drzewa nazwy poszczegówlnych węzłów
 *
 * @author MicKar
 *        
 */
class MergeData
{

    /**
     * metoda dodaje do drzewa nazwy poszczegówlnych węzłów z listy zdefiniowanych kategorii(ListMap)
     *
     * @param \stdClass[] $tree
     *            drzewo do uzupelnienia
     * @param ListMap $map
     *            mapa z kategoriami
     * @throws TypeException
     * @return \stdClass[]
     */
    public function execute(array $tree, ListMap $map): array {

        // lista elementów do przetworzenia, przetwarzając jedne dodaje wszystkie jego dzieci
        $runtimeList = $tree;

        for ($i = 0; isset($runtimeList[$i]); $i ++) {

            $treeElement = $runtimeList[$i];

            if (! ($treeElement instanceof \stdClass)) {
                throw new TypeException("Oczekiwano obiekty typy: stdClass");
            }

            // dodaj nazwe
            $treeElement->name = $map->getNameById($treeElement->id);

            // dodaje dzieci do przetworzenia
            foreach ($treeElement->children as $child) {
                $runtimeList[] = $child;
            }
        }

        return $tree;
    }
}