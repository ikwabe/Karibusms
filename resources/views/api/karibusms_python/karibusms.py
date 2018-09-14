import urllib2

u='username'
p='userpass'
url='https://api.github.com/users/username'

# simple wrapper function to encode the username & pass
def encodeUserData(user, password):
    return "Basic " + (user + ":" + password).encode("base64").rstrip()

# create the request object and set some headers
req = urllib2.Request(url)
req.add_header('Accept', 'application/json')
req.add_header("Content-type", "application/x-www-form-urlencoded")
req.add_header('Authorization', encodeUserData(u, p))
# make the request and print the results
res = urllib2.urlopen(req)
print res.read()