<?php

namespace sayhuite\procedures;
use DB;


class sp_Procedures
{
	public function sp_inf_fianciera($ambito,$opcion,$anio)
    {
        return DB::select('select * from sp_inf_fianciera_pp(?,?,?)' ,array($ambito,$opcion,$anio));
    }

}
