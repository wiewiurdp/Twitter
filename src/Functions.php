<?php
/**
 * Created by PhpStorm.
 * User: mateusz
 * Date: 19.05.17
 * Time: 09:45
 */
function descCreationDateSorter($a, $b)
{
    return strcmp($b->getCreationDate(),$a->getCreationDate());
}
function ascCreationDateSorter($a, $b)
{
    return strcmp($a->getCreationDate(),$b->getCreationDate());
}
