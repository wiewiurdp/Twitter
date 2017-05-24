<?php
function descCreationDateSorter($a, $b)
{
    return strcmp($b->getCreationDate(),$a->getCreationDate());
}
function ascCreationDateSorter($a, $b)
{
    return strcmp($a->getCreationDate(),$b->getCreationDate());
}
function ascUsernameSorter($a, $b){
    return strcmp($a->getUsername(),$b->getUsername());

}