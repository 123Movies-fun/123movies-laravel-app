## About 123Project

There are 3 main projects that work together to form the infrastructure:

### MainBot
Website interface, database, parser/cloudbot coordination, etc... 

https://gitlab.com/acorbin91/imdbLinks

### ParserBot
Parses web pages for mp4's and metadata. 

https://gitlab.com/acorbin91/imdb-links-parserbot

### CloudBot
Receives data from ParserBot (with permission from MainBot) and uplaods/tranloads mp4 to cloud storage. Sends data to MainBot for DB storage upon completion

https://gitlab.com/acorbin91/imdb-links-cloudbot

## Deploying MainBot

1. git clone https://gitlab.com/acorbin91/imdbLinks
2. composer install
3. npm install --global gulp-cli
4. npm install elixir
5. npm install
6. Manually install a clone of the database.sql
7. Update .env file

## Questions?

Email [andrew@codebuilder.io](mailto:andrew@openpad.io) for questions or concerns.
