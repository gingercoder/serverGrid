# File: servergrid.coffee
# Description:
#  ServerGrid Response Mechanisms - Allows checking of server state from ServerGrid Installation
#
# Dependencies:
#   None
#
# Configuration:
#   None
#
# Commands:
#   servergrid help
#   servergrid ping servername
#   servergrid load servername
#   servergrid how much disk is left on servername
#   servergrid describe servername
#   servergrid list servers
#   servergrid help
#
# Author:
#   Rick Trotter

# INSTALLATION Instructions
# !=======================!
#
# REMEMBER TO :
# 1) CHANGE THE URL OF YOUR SERVER
# 2) CHANGE THE KEY USED TO CONNECT IN THE FOLLOWING SCRIPT AND IN HUBOT.PHP

module.exports = (robot) ->

 robot.hear /servergrid ping (\w+)/i, (msg) ->
  server = msg.match[1]
  msg.http('http://MY_SERVER_URL/api/hubot.php/CHANGE_THIS_KEY/ping/'+server)
   .get() (error, response, body) ->
    msg.send body

 robot.hear /servergrid load (\w+)/i, (msg) ->
  server = msg.match[1]
  msg.http('http://MY_SERVER_URL/api/hubot.php/CHANGE_THIS_KEY/load/'+server)
   .get() (error, response, body) ->
    msg.send body

 robot.hear /servergrid how much disk is left on (\w+)/i, (msg) ->
  server = msg.match[1]
  msg.http('http://MY_SERVER_URL/api/hubot.php/CHANGE_THIS_KEY/disk/'+server)
   .get() (error, response, body) ->
    msg.send body

 robot.hear /servergrid describe (\w+)/i, (msg) ->
  server = msg.match[1]
  msg.http('http://MY_SERVER_URL/api/hubot.php/CHANGE_THIS_KEY/info/'+server)
   .get() (error, response, body) ->
    msg.send body

 robot.hear /servergrid list servers/i, (msg) ->
  msg.http('http://MY_SERVER_URL/api/hubot.php/CHANGE_THIS_KEY/list/')
   .get() (error, response, body) ->
    msg.send body

 robot.hear /servergrid help/i, (msg) ->
  msg.send "ServerGrid Commands:\nping servername\nload servername\nhow much disk is left on servername\ndescribe servername\nlist servers\nhelp"


 robot.hear /servergrid graph load on (\w+)/i, (msg) ->
   server = msg.match[1]
   msg.http('http://MY_SERVER_URL/api/hubot.php/CHANGE_THIS_KEY/graphload/'+server)
    .get() (error, response, body) ->
     msg.send body
