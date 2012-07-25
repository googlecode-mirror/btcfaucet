-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 24, 2012 at 07:38 PM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `BTCFaucet`
--

-- --------------------------------------------------------

--
-- Table structure for table `ip_table`
--

CREATE TABLE `ip_table` (
  `ip` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `access_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `ip_table`
--

