-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_form_field`
-- 

CREATE TABLE `tl_form_field` (
  `memberGroups` blob NULL,
  `includeBlankOption` char(1) NOT NULL default '',
  `blankOptionLabel` varchar(128) NOT NULL default '',
  `outputFormat` varchar(30) NOT NULL default '',
  `returnValue` varchar(4) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
