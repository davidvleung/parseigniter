ParseIgniter
---
v.1.0.0

Description
-------------
Parse.com library for CodeIgniter

Motivation
-------------
I was using Parse.com for a personal project but also needed a web interface
for the data produced.  Luckily Parse.com provides a <a href="https://www.parse.com/docs/rest">REST API</a>. 
  Having not worked with cURL requests before,
it took me some time to figure out the proper structure.  But the point is that
there is a structure and I thought it could be encapsulated generically.  Also,
I did not have want to duplicate cURL calling code.

Since I was using CodeIgniter for my framework, I decided that a library would
be the cleanest and most global route while maintaing the coding feel that 
CodeIgniter's framework provides.

Please try it out and let me know what you think.  I've only started with what
I needed so there is likely room for much improvement. 

Installation
-------------
1. Copy Parse.php to the /libraries folder of your CodeIgniter project.
2. Replace the $app and $key to your own values from Parse.com.
3. Done!

Usage
-------------

First, load the library like how you do with all CodeIgniter libraries:

    $this->load->library('Parse');

Then, you are ready to work with Parse.com using any of the following functions!

Note all responses are in JSON format.

<b>Retrieve<b>

    $this->parse->getParseObj($objType, $id, $params);

- $objType - the name of the Parse class type.
- $id (optional) - is the Object ID of the Parse class type.
- $params (optional) - is an array of valid Parse.com REST parameters.
    
<b>Update</b>

    $this->parse->updateParseObj($obj, $id, $params);

- $obj - the name of the Parse class type.
- $id - Object ID of Parse class type
- $params (optional) - array of class attributes

<b>Create</b>

	$this->parse->newParseObj($obj, $params);

- $obj - the name of the Parse class type.
- $params (optional) - array of class attributes    
    
<b>Upload</b>

    $this->parse->upload($path, $filename, $type);

- $path - path of file
- $filename - filename of file
- $type - file extension

Examples
-----

Retrieve a list of employees that belong to a company in descending created 
order.  Note that the list of values exist under the "results" name in the JSON response.

	$params = array(
		"where={\"company_id\": 1}",
		"order=-createdAt"
	);
	$employees = json_decode($this->parse->getParseObj('Employee', null, $params));

	foreach($employees->results as $employee) {
		echo $employee->name . " " . $employee->company_id;
	}


