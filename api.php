<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/FeedbackService.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $raw   = file_get_contents('php://input');
    $input = $raw ? json_decode($raw, true) : null;
    if (!is_array($input)) $input = $_POST;

    $action   = (string)($input['action'] ?? '');
    $feedback = new FeedbackService(getPDO());
    $result   = $feedback->doFeedbackAction($action, $input);

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}