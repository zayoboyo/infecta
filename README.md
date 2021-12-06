## Infecta
Demo: [Try out Infecta](https://infecta.appswing.net/)
### Description
<p>Infecta is a web browser based game about solving RNA of viruses and creating mRNA based vaccine based on the RNA.</p>
<p>Every five seconds, the game ticks and randomly discovers new diseases that are added to the main list.</p>
<p>After new virus has been discovered, you need to click the green test tube icon to open the laboratory.</p>
<p>In the laboratory, you need to click the button Solve RNA. Based on the difficulty settings, it might take shorter or longer period of time to solve the RNA.</p>
<p>After solving the RNA, you can leave the laboratory. You will notice a new red icon with syringe becomes available. After clicking on the red icon with syringe, you will eradicate the virus by making a new mRNA vaccine for the virus.</p>

### Installation
1. Clone the repository
2. Run ```composer install```
3. Run ```npm install```
4. Rename the file ```.env.example``` to ```.env```
5. Open the ```.env``` file and add database connection
6. Run ```php artisan key:generate```
8. Run ```php artisan migrate```
9. Run ```npm run prod```
10. Optional: Tweak the difficulty variables in the ```.env``` file as described below.

<p>The game difficulty is fully customizable via environment variables. Parameter list:</p>

| Variable             |                                      Description                                       |
|----------------------|:--------------------------------------------------------------------------------------:|
| DISEASE_SPAWN_CHANCE | Chance that new disease will be discovered on the next tick. Possible values: 0 to 100 |
| MAXIMUM_DISEASES     |           Maximum amount of diseases that can be present at any given time.            |
| MINIMUM_DIFFICULTY   |              Minimum difficulty to solve one nucleotide, in milliseconds.              |
| MAXIMUM_DIFFICULTY   |              Maximum difficulty to solve one nucleotide, in milliseconds.              |

## License

Infecta is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
