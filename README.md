## NVISION Assignment README

### User create using below url
post url : http://127.0.0.1:8086/api/register

Sample Data :

{
    "name": "xxxxxxx",
    "email": "xxxxxxx",
    "password": "xxxxxxxxxx" <--- (password should be more than 8 characters)
}

### Token create using below url
post url : http://127.0.0.1:8086/api/token

Sample Data :

{
    "email": "xxxxxxx",
    "password": "xxxxxxx",
    "device_name": "xxxxxxxxxx"
}

## Stage 01

Question 01 / 02 : 

Answer : Please Get below Token For Post Protected API. If you want to new tocken, please check api route. You can Create New Token.

Authorization Type : Bearer Token
Access_Token : "3|6nYn8Z8zyVGXZBLBbvDx1nziuayRxoOgIQzx45qG8dafcc48"
post url : http://127.0.0.1:8086/api/create-order

Sample Data :

{
    "customer_name": "John Bernad",
    "order_value": 150
}

## Stage 02

Question 02 : Based on the high demand for API requests, suggest a method to queue the API requests into
the server. (Ex: new orders should wait until the configured number of parallel requests are
reached)

Answer : For above question i have apply queue system. Please check with my code.

Question 03 : Create a simple web form with 3 input parameters. After submitting the form, values should be
stored in browser-based “Indexed DB”. Create a simple data table to view the above
information from “Indexed DB”.

Answer : You can check the first page of the system.
