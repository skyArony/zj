<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

// QQ 绑定
class QQ extends Model
{
  protected $table = 'user_qq';
  protected $primaryKey = 'qq_id'; // 指定主键
  protected $keyType = 'char'; // 主键数据类型
  public $timestamps = false;
  protected $fillable = ['qq_id', 'user_id', 'user_info'];

}
