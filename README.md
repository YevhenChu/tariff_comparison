## Initialization and configuration

For initialization this project you need to run <code>make init</code> command in the root forlder of the project. This command downloads all images of docker and launch the project.

For starting the project you can use the <code>make start</code> command.

Also you can use the <code>make down</code> command for stopping docker conteiners.

The <code>make build</code> command re-build docker containers.

 
> [!IMPORTANT]
> Before working with this project you need to get an **IP address of your local machine** and put it in the <code>TARIFF_PROVIDER_BASE_URL=http://192.168.77.206:8000/api</code> of the <code>web/.env</code> file. 
> This is need because I moched _Tariff Provider_ data on the same host.
> 
> For this you need to run the <code>hostname -I</code> command in the terminal. 
> ![2024-06-05_16-54](https://github.com/YevhenChu/tariff_comparison/assets/137170406/bffba33d-698f-46d7-af7c-fe09644e0ab3)

## Retrieving data

For retrieving the Annual Costs data you can use the curl command:
<pre>curl --location 'http://localhost:8000/api/tariffs/comparison' --form 'consumption="3500"'</pre>
or you can use a postman.

## Tests

The application code is covered by the test. 

For running tests you can use <code>make test</code> or <code>make test-coverage</code> command

![2024-06-05_16-32](https://github.com/YevhenChu/tariff_comparison/assets/137170406/31032cc8-e11d-4438-8c37-3c4fd8c2701b)
