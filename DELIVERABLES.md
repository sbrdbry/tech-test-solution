# A Tech-Test Solution - Deliverables



## Development Choices


###### Zend Framework


ZF 3 was adopted which provides the MVC architecture. There was a similar Zend project to hand
that was performing well, and it was faily reusable.

###### The Markup (form.html)


At first, it was decided that the markup in form.htnl would be followed to the letter.

###### PDO


There are several ways to connect to databases in Zend, but PDO is probably the simplest and easiest to read.

###### Zend\Form


Zend\Form offers several benefits, but it is primarily designed to bind to 
one record. Since there were many records in the form from the markup, it was decided Zend\Form would be omitted and
the form would be handled in the controller.

###### Normalization


There was plenty of alloted time left, so the Job Roles field was serperated into a lookup table to demonstrate normalization.

###### New Markup


With the new database structure, it made sense to have a select input on the form. This solves validation issues and helps to maintain data integrity. It also meant there had to be a way to manage the data in the new lookup table, for this reason another module was set up with a consistent form design.

###### Security


To demonstrate security, Zend\Form was reintroduced for its easy to implement CSRF feature.

###### Performance


Caching was enabled in the config/application.config.php file, for improved performance.

###### Validation


For more security and database integrity, form validation was added to the post request in the controller.

###### Data Integrity


A foreign key was added, referencing the lookup table. 

###### Scalability


The number of allowed records can be easily changed and so can the numbger of Job Roles assignments. Pagination can be added with a few lines of code at the bottom of the views. There is a Dockerfile, so the project can be Dockerized and deployed in a high availablility and fully scalable environment. 




## Time Taken

| Task                                                                           | Time       |
| ------------------------------------------------------------------------------ | ---------- |
| Cloned a similar project                                                       | 15 minutes |
| Altered the project to represent the model                                     | 15 minutes | 
| Swapped SQLite3 for MySQL                                                      | 20 minutes | 
| Changed the structure of the project to satisfy form.html                      | 2 hours    | 
| Omitted Zend\Form for simplicity                                               | 2 minutes  | 
| Added the restrictions outlined in the brief (10 records, 4 assigned Job Roles)| 15 minutes | 
| Restructured the database to include a Job Roles lookup table                  | 1 hour     | 
| Made changes to the modules to reflect the new models                          | 1 minute   | 
| Added Zend\Form back to utilize a CSRF token                                   | 25 minutes | 
| Enabled caching to enhance performance                                         | 2 minutes  | 
| Added some validation to Add & Update actions                                  | 2 minutes  | 
| Added a foreign key to control dependencies in the database                    | 5 minutes  | 
| Testing & bug fixes                                                            | 2 hours    | 
| Documentation                                                                  | 1 hour     | 
| Signed the application                                                         | 5 minutes  | 
| Pushed the app to GitHub                                                       | 5 minutes  | 
|                                                                                |            |
| Total                                                                          | 11hrs 04m  | 




## VCS History

The git bundle can be found [here](https://github.com/sbrdbry/tech-test-solution/blob/main/reimagined-octo-waddle.bundle).

