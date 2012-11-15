<?php
App::uses('Enum', 'Model');

class Status extends Enum {

    const SENT = 'sent';
    const IN_PROGRESS = 'in_progress';
    const RESOLVED = 'resolved';
    const IGNORED = 'ignored';


}
