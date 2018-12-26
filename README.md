# speciesDatabase
A Database to store all kinds of species

"speciesDatabase", or simply "spDB", is a PHP programming intending to give a friendly plataform where you can add and edit a list of species, cataloging them according to their taxonomic hierarchy.

Configuration
1. Create a database;
2. Go to "includes" folder, rename "connect-edit.php" to "connect.php", open, complete with yours connections vars and save this file;
3. After populate your database with some species, go to "index.php" file and do these edits:
- Complete with a title that match with your id from the line below: echo \'Choose a title\';
- Complete with a disere id to be this list parent: taxa_recursive_tree(\'id\');
- Create your custom modules in "modules" folder and insert then in this field: include_once \'modules/your_custom_module.php\';

# Made with the help of
- Bootstrap https://getbootstrap.com/
- Font Awesome https://fontawesome.com/
- Tiny MCE https://www.tiny.cloud/
