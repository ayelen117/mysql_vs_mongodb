/**
 * Created by nsilva on 4/22/17.
 */
conn = new Mongo();
db = conn.getDB("mongo_testing");
db.createCollection("testing_db_init");
db.createUser({user: "test_user", pwd: "test_password", roles: [ "readWrite", "dbAdmin" ]});

databases = conn.getDBNames();
printjson(databases);