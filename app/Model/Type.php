<?php
App::uses('Enum', 'Model');

class Type extends Enum {

    const MAINTENANCE = 'maintenance';
    const BUG = 'bug';
    const EVOLUTION = 'evolution';

}
