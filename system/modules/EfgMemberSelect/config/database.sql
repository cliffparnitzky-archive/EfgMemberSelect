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
  `efgMemberSelectMembers` blob NULL,
  `efgMemberSelectMemberGroups` blob NULL,
  `efgMemberSelectIncludeBlankOption` char(1) NOT NULL default '',
  `efgMemberSelectBlankOptionLabel` varchar(128) NOT NULL default '',
  `efgMemberSelectOutputFormat` varchar(32) NOT NULL default '',
  `efgMemberSelectReturnValue` varchar(32) NOT NULL default '',
  `efgMemberSelectRemoveLoggedMember` char(1) NOT NULL default '',
  `efgMemberSelectShowInactiveMembers` char(1) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
