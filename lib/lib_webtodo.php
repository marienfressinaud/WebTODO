<?php

function timestamptodate ($t, $hour = true) {
	$jour = date ('d', $t);
	$mois = date ('m', $t);
	$annee = date ('Y', $t);
	
	switch ($mois) {
	case 1:
		$mois = 'janvier';
		break;
	case 2:
		$mois = 'février';
		break;
	case 3:
		$mois = 'mars';
		break;
	case 4:
		$mois = 'avril';
		break;
	case 5:
		$mois = 'mai';
		break;
	case 6:
		$mois = 'juin';
		break;
	case 7:
		$mois = 'juillet';
		break;
	case 8:
		$mois = 'août';
		break;
	case 9:
		$mois = 'septembre';
		break;
	case 10:
		$mois = 'octobre';
		break;
	case 11:
		$mois = 'novembre';
		break;
	case 12:
		$mois = 'décembre';
		break;
	}
	
	$date = $jour . ' ' . $mois . ' ' . $annee;
	if ($hour) {
		return $date . date (' \à H\:i', $t);
	} else {
		return $date;
	}
}

function sortTasksByDate ($task1, $task2) {
	$date1 = $task1->date (true);
	$date2 = $task2->date (true);
	$res = $date1 - $date2;

	if ($res == 0) {
		return strnatcasecmp ($task1->libelle (), $task2->libelle ());
	} else {
		if ($date1 == 0) {
			return 1;
		} elseif ($date2 == 0) {
			return -1;
		} else {
			return $date1 - $date2;
		}
	}
}

function sortArchivesByDate ($task1, $task2) {
	$date1 = $task1->dateFin (true);
	$date2 = $task2->dateFin (true);
	$res = $date1 - $date2;

	if ($res == 0) {
		return strnatcasecmp ($task1->libelle (), $task2->libelle ());
	} else {
		if ($date1 == 0) {
			return 1;
		} elseif ($date2 == 0) {
			return -1;
		} else {
			return $date2 - $date1;
		}
	}
}
