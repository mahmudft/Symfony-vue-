### Symfony & Vue 
- Symfony , Postgresql, Mailer for backed
- Vue, Vuetify for frontend (vue files are compiled and embeded in base.html.twig template)



###Instrcutions to start up server 

#### Install symfony dependencies

`$ composer install

#### Install Vue dependencies(Step can be skipped I have added pre-compiled build directory)

`$ npm install 


####SetUp PostgreSql credentials in .env file

   ```
   DATABASE_URL= //credentials
   ```
    
####Start Feeding the Database by tis command

   ```
   symfony console fruits:fetch
   ```
####Compile .vue files(Optional)

   ```
   npm run build
   ```
    
####Start the Main Symfony Application

   ```
   symfony serve --no-tls
   ```
    
