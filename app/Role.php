<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use \OwenIt\Auditing\Auditable;

}
