<?php 

namespace App\Collection;

use Illuminate\Database\Eloquent\Collection;
/**
 *	私信 collection  
 */
class MessageCollection extends Collection
{
	public function markAsRead()
	{
		$this->each(function($message){

			if($message->to_user_id === \Auth::user()->id){
				$message->markAsRead();
			}
		});
	}
}