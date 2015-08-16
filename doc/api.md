# API design


## Info about login user
- `/me` return list of information about login user
- this functions is without test
- for example `curl -X GET http://service-domain.com/me`


## Info about user
- `/get-info/3` return list of information about user. User is specific with ID = 3
- this functions is without test
- for example `curl -X GET http://service-domain.com/get-info/3`


## Add new user
- `/add` add user
- this functions is without test
- for example `curl -X POST --data "email=test@domain.com&password=12345" http://service-domain.com/add`
