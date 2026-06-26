-- ============================================================
-- NIN Pricing Table (if not already existing)
-- ============================================================
CREATE TABLE IF NOT EXISTS `nin_pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slip_type` varchar(100) NOT NULL,
  `user_price` decimal(10,2) NOT NULL,
  `agent_price` decimal(10,2) NOT NULL,
  `vendor_price` decimal(10,2) NOT NULL,
  `status` enum('On','Off') NOT NULL DEFAULT 'On',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `nin_pricing` (`slip_type`, `user_price`, `agent_price`, `vendor_price`, `status`) VALUES
('NIN Slip', 200.00, 180.00, 150.00, 'On'),
('NIN Premium Slip', 350.00, 300.00, 250.00, 'On');

-- ============================================================
-- Services Pricing Table (Buy Number, Buy Logs, Boost Socials, BVN, CAC Registration)
-- ============================================================
CREATE TABLE IF NOT EXISTS `verification_pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_type` varchar(50) NOT NULL COMMENT 'buy_number, buy_logs, boost_socials, bvn, cac_registration',
  `plan_name` varchar(100) NOT NULL,
  `user_price` decimal(10,2) NOT NULL,
  `agent_price` decimal(10,2) NOT NULL,
  `vendor_price` decimal(10,2) NOT NULL,
  `status` enum('On','Off') NOT NULL DEFAULT 'On',
  PRIMARY KEY (`id`),
  KEY `service_type` (`service_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `verification_pricing` (`service_type`, `plan_name`, `user_price`, `agent_price`, `vendor_price`, `status`) VALUES
('buy_number', 'Nigeria - Basic', 200.00, 150.00, 100.00, 'On'),
('buy_number', 'USA - Basic', 500.00, 400.00, 300.00, 'On'),
('buy_number', 'UK - Basic', 500.00, 400.00, 300.00, 'On'),
('buy_logs', 'Facebook Log', 1500.00, 1200.00, 1000.00, 'On'),
('buy_logs', 'Instagram Log', 2000.00, 1500.00, 1200.00, 'On'),
('buy_logs', 'Gmail Log', 1000.00, 800.00, 600.00, 'On'),
('boost_socials', 'Instagram Followers - 500', 1500.00, 1200.00, 1000.00, 'On'),
('boost_socials', 'Instagram Followers - 1000', 2500.00, 2000.00, 1500.00, 'On'),
('boost_socials', 'TikTok Followers - 500', 1500.00, 1200.00, 1000.00, 'On'),
('bvn', 'BVN Verification', 100.00, 80.00, 50.00, 'On'),
('bvn', 'BVN Modification', 500.00, 400.00, 300.00, 'On'),
('cac_registration', 'Business Name / Enterprise Registration', 28000.00, 25000.00, 22000.00, 'On'),
('cac_registration', 'Limited Liability Company Registration', 50000.00, 45000.00, 40000.00, 'On'),
('cac_registration', 'Incorporated Trustees Registration', 120000.00, 110000.00, 100000.00, 'On');

-- ============================================================
-- API Config Keys for NINBVNPORTAL and Megaboost (if not existing)
-- ============================================================
INSERT INTO `apiconfigs` (`name`, `value`) VALUES
('ninBvnApiKey', ''),
('ninBvnApiUrl', 'https://ninbvnportal.com.ng/api'),
('megaboostApiKey', ''),
('megaboostApiUrl', 'https://megaboost.com.ng/api/v1')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ============================================================
-- CAC Registrations Table (full submission storage)
-- Fields based on actual CAC Nigeria 2026 requirements
-- ============================================================
CREATE TABLE IF NOT EXISTS `cac_registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ref` varchar(100) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `business_type` varchar(50) NOT NULL COMMENT 'Business Name, Limited Liability, Incorporated Trustee',
  `first_choice_name` varchar(200) NOT NULL COMMENT 'Primary business/company name',
  `second_choice_name` varchar(200) DEFAULT NULL COMMENT 'Alternative name',
  `nature_of_business` text DEFAULT NULL,
  `business_address` text DEFAULT NULL COMMENT 'Physical address required (no PO Box)',
  `applicant_name` varchar(200) NOT NULL,
  `applicant_email` varchar(200) NOT NULL,
  `applicant_phone` varchar(50) NOT NULL,
  `proprietor_name` varchar(200) DEFAULT NULL COMMENT 'Business Name - proprietor full name',
  `proprietor_dob` date DEFAULT NULL COMMENT 'Business Name - date of birth',
  `proprietor_address` text DEFAULT NULL COMMENT 'Business Name - residential address',
  `id_type` varchar(50) DEFAULT NULL COMMENT 'NIN, Driver License, Intl Passport, Voters Card',
  `id_number` varchar(100) DEFAULT NULL COMMENT 'ID document number',
  `director_details` longtext DEFAULT NULL COMMENT 'Limited Liability - JSON array of directors',
  `share_capital` decimal(15,2) DEFAULT NULL COMMENT 'Limited Liability - share capital',
  `shareholder_details` longtext DEFAULT NULL COMMENT 'Limited Liability - JSON of shareholders',
  `aims_objectives` longtext DEFAULT NULL COMMENT 'Incorporated Trustee - aims and objectives',
  `trustee_details` longtext DEFAULT NULL COMMENT 'Incorporated Trustee - JSON array of trustees',
  `additional_info` text DEFAULT NULL,
  `status` enum('pending','processing','completed','rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `document_path` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref` (`ref`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
