<?php

/**
 * Author: raymond
 * Date: 28/12/15
 * Time: 11:55 AM
 * add some own class
 */
class Slugger
{
  public function slugify($option)
  {
    return preg_replace('/[^a-z0-9]/', '-', strtolower(trim(strip_tags($option))));
  }

}