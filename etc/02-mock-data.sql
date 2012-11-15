INSERT INTO `projects` (id,`name`, description, created, modified) VALUES
  (1,'Slashbug','The bugtracker','2012-10-15','2012-10-15'),
  (2,'Henner Investigation','Henner Investigation','2012-04-20','2012-09-12');


INSERT INTO `requests` (id,`name`, `description`, `created_by`, `project_id`, `type`, `priority`, `status`, `minutes_spent`, `assigned_to`, `created`, `modified`) VALUES
  (1,'Pouvoir éditer son projet','En tant qu'' utilisateur je veux pouvoir éditer le libellé et la description d''un projet', 1, 1, 'evolution','normal','sent',null,null,'2012-11-15','2012-11-15');
