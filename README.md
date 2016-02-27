[Emu](https://hrn4n.github.io/emulator)
===
A server emulator written in PHP

Q: *A server what?*

A: It reads a file and then listens on a port, **any** request made on that port will get the file's contents as the response, regardless of the request body (This part will be changed later on)

Q: *Why?*

A: I had two motivations for this project, I needed a tool that could do this, I wanted to try out a few new things I learned in PHP


Usage
-----
```
emulator.phar [config file name] [port number]
```

Where the config file is the path to the JSON file containing the configuration for the emulator, and the port is the port on which the emulator will listen.

**Config file structure**

Config file will be a JSON Object, it can contain the following parameters:

- **sourceType** *string* - Possible values: raw, file
- **data** *string* - If source type is "raw" then the emulator will use the value of this parameter as the response to every request
- **dataLocation** *string* - Path to the file that will be used to respond to every request (the file's contents will be sent to every request).
- **loadOnce** (optional) *boolean* - Default: true - Whether or not source file should be read only when emu is loaded or once every time a request is received


Below is a sample config.json file that could be used:

```json
{
  "sourceType": "file",
  "dataLocation": "sample.txt"
}
```

Contributing
------------
Take a look at the issues page (open an issue if you have to), make some changes and send a pull request! (Be sure to explain  your changes though)