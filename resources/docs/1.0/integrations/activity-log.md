# Laravel Activity log

This section includes all the details about users activity logging functionality. 

This project uses `spatie/larave-activity-log`

# Logging Auth User 
1- by simply trying to add `use LoggingTrait;` in Model/Controller you could achieve
logging by just `$this->log($destination_model,"some description",[])`

