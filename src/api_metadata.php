<?php

header('Content-Type: application/json');
http_response_code(200);

$legacy_salt_value = "SuperSecretLegacySaltXYZ";

$metadata = [
    "api_version" => "1.0.1-beta",
    "status" => "operational",
    "last_updated" => "2025-07-29",
    "security_info" => [
        "hashing_algorithm_for_legacy_data" => "MD5",
        "deprecated_hashing_notes" => "MD5 is considered insecure for password storage. This is only for legacy identifiers.",
        "legacy_data_salt_flag" => "WebSec{th3_s4lt_1s_exp0s3d}",
        "legacy_data_raw_salt_value" => $legacy_salt_value,
        "how_legacy_hash_is_computed" => "concatenates_secret_then_salt",
        "common_secret_format_hint" => "secret often starts with _ and ends with }", 
        "secret_keyword_hint" => "think_about_the_state_of_a_completed_challenge_and_a_broken_hash",
        "secret_character_set_hint" => "consists_of_lowercase_letters_numbers_and_underscores",
        "secret_length_hint" => 13,
        "next_generation_security_module" => "/api/v2/secure_auth.php"
    ],
    "endpoints" => [
        "/api/users",
        "/api/courses",
        "/api/transactions"
    ]
];

echo json_encode($metadata, JSON_PRETTY_PRINT);
