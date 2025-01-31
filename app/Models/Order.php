<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;
    //khi chạy thì xoá đoạn /XOA đi
    protected $slackChannels= [
        'don-hang' => 'https://hooks.slack.com/services/XOA/T01HZ3FJSKH/B01JEC8FMQT/OxIGfe3FUksZ3r15fpUrWK6J',
        'nhan-vien' => 'https://hooks.slack.com/services/XOA/T01HZ3FJSKH/B01JELUDTSP/nnYI1CcQbBHtXWC5vG1ggCq6',
    ];    
    protected $slack_url = null;
    /////
    protected $table='orders';
    protected $primaryKey='ord_id';
    protected $fillable =[
        'ord_fullname',
        'ord_address',
        'ord_email',
        'ord_phone',
        'ord_total',
        'ord_state'
    ];
    // public function details()
    // {
    //     return $this->hasMany(OrderDetail::class,'ord_detail_id','ord_id');
    // }
    public function details()
    {
        return $this->hasMany(OrderDetail::class,'ord_id');
    }
    //// slack
    
    public function setSlackUrl($url){
        $this->slack_url = $url;
        return $this;
    }
    public function setSlackChannel($name){
        if(isset($this->slackChannels[$name])){
            $this->setSlackUrl($this->slackChannels[$name]);
        }
        return $this;
    }
    public function routeNotificationForSlack($notification){
        if($this->slack_url === null){
            return $this->slackChannels['don-hang'];
        }else{
            return $this->slack_url;
        }
    }
}
