<?php foreach ($events as $event): ?>
<?php echo $event['Event']['title'] . ' , "' . $event['EventType']['name'] . '" , ' . $event['Event']['status'] . ' , "'?><?php if(!empty($event['Contact'])){
			foreach($event['Contact'] as $contact){
				echo $contact['full_name'] . ', ';
			}
		}
		else {
			echo " ";
		}?><?php echo '" ,'; ?><?php if(!empty($event['User'])){
			foreach($event['User'] as $user){
				echo $user['full_name'] . ', ';
			}
		}
		else {
			echo " ";
		}?><?php echo '" , ' . $event['Event']['start'] . '" , '; ?><?php if($event['Event']['all_day'] == 0) { echo $event['Event']['end']; } else { echo 'N/A'; } ?><?php echo ' , '; if($event['Event']['all_day'] == 1) { echo "Yes"; } else { echo "No"; } echo "\r\n" ?>
<?php endforeach; ?>