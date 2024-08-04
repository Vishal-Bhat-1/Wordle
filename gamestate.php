<?php
session_start();

// Initialize game state and leaderboard
if (!isset($_SESSION['game_state'])) {
  $_SESSION['game_state'] = array(
    'secret' => '',
    'grid' => array_fill(0, 6, array_fill(0, 5, '')),
    'currentRow' => 0,
    'currentCol' => 0,
    "leaderboard"
  );
}
if (!isset($_SESSION['leaderboard'])) {
  $_SESSION['leaderboard'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'];

  if ($action === 'get_state') {
    echo json_encode($_SESSION['game_state']);
  }

  if ($action === 'update_state') {
    $_SESSION['game_state'] = json_decode($_POST['game_state'], true);
  }

  if ($action === 'submit_guess') {
    $guess = $_POST['guess'];
    $secret = $_SESSION['game_state']['secret'];
    $response = array('guess' => $guess);
    echo json_encode($response);
  }

  if ($action === 'update_score') {
    $score = intval($_POST['score']);
    $leaderboard = $_SESSION['leaderboard'];
    $leaderboard[] = $score;
    rsort($leaderboard);
    $_SESSION['leaderboard'] = array_slice($leaderboard, 0, 10);
  }
}
?>