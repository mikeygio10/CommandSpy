<?php

namespace tim03we\CommandSpy;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Main extends PluginBase {
	public $snoopers = [];
	
	public function onEnable(): void {
		@mkdir($this->getDataFolder());
		$this->getLogger()->info("CommandSpy wurde aktiviert! Lass das Spionieren beginnen.");
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
	  	"Console.Logger" => "true",
  		));
	}
	
	 public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {			
		if(strtolower($command->getName()) == "commandspy" or strtolower($command->getName()) == "cspy") {
		 	if($sender instanceof Player) {
				if($sender->hasPermission("commandspy.cmd")) {
					if(!isset($this->snoopers[$sender->getName()])) {
						$sender->sendMessage("§8cspy is now §aOn");
						$this->snoopers[$sender->getName()] = $sender;
						return true;
					} else {
						$sender->sendMessage("§cDu hast den Spy-Mode verlassen.");
						unset($this->snoopers[$sender->getName()]);
						return true;
						}
				} else {
       						$sender->sendMessage("§8cspy is now §cOff");
       						return true;
					}
				}
			}
		return true;
	 }
}
