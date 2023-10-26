<?php

namespace ThisMadCat;
use ThisMadCat\STMC;
use pocketmine\Player;

class CartForm{

		    private $plug;
		    function __construct(STMC $plug){
		        $this->plug = $plug;
		    }
		    function open(Player $pl){
		        $f = $this->plug->form->createCustomForm(function (Player $pl, $data){
						$ra = $this->plug->ra->getAll();
						$bank = $this->plug->bank->getAll();
						$gm = $bank[$pl->getName()]["kol"];
					if($data[0] !== NULL){
							//data[0] - сумма
							/*
							*  $sender->sendMessage("§7Ваш счёт состовляет §b" . $bank[$sender->getName()]["kol"]);
	            *  $sender->sendMessage("§7Ваш счёт дипозита состовляет §b" . $bank[$player->getName()]["dipozit"]);
							*               $ra["mon"][$p->getName()] -= 3000;
							*             $this->ra->setAll($ra);
						  *             $this->ra->save();
							*/
							if($gm >= $data[0]){
								if($data[0] != ""){
						  	  $pl->sendMessage("§l§3Вы §l§aуспешно §l§3сняли деньги");
						  	  $pl->sendMessage("§7Чек на операцию: \nСнято с карты - §a{$data[0]}§7$");
						  	  $bank[$pl->getName()]["kol"] -= $data[0];
						    	$this->plug->bank->setAll($bank);
						    	$this->plug->bank->save();
						     	$ra["mon"][$pl->getName()] += $data[0];
							    $this->plug->ra->setAll($ra);
						  	  $this->plug->ra->save();
								}else $pl->sendMessage("§7Вы нечего не написали");
							}else $pl->sendMessage("§7У вас нехватает средств на карте.");
					} else $this->open($pl);
		        });
		        $f->setTitle("§3Банкомат");
		        $f->addInput("Сумма", "Например: 100,1000");
		        $f->sendToPlayer($pl);
		        return $f;
		    }
		}
