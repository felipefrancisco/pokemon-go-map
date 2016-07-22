**DISCLAIMER**

This project's core functionality was first developed within a 4-5 hours, from 1AM to 5-6AM of July 12st, I made this map tool
just because I love Pokémon, but things got out of control and after 3 days of go live, the map was receiving 30k visitors per
day. After that, I've spend lots of hours during the night developing like crazy to get things working properly and creating 
new features, that's why things can look terrible (mostly on the front-end). I was planning to use AngularJS to control everything
but the controllers are not following the rules of good development of angular for reasons that: I needed to create and fix things quickly, so, the first thing that solved the problem was ok for me at that moment HAHA.

### That's why the front-end and database are so messy. This is far from what I consider to be good.

The idea of going open source with this project is exactly to put everything on the right place and keeping the project alive.
Any questions, feel free to open an [issue](https://github.com/felipefrancisco/pokemon-go-map/issues), I'll be happy to help.

---

# Pokémon GO World Map
Welcome, trainer. This is a colaborative Pokémon GO map tool created to help players find their favorite Pokémon location around the world. You can access the website here: www.pokemon-map.com

You can contribute by submitting a pull request to the `develop` branch with a small changelog.

If you want to contribuite but don't know what to do, you can check the [issues](https://github.com/felipefrancisco/pokemon-go-map/issues) section, there you'll find bugs reported by users and `offcial tasks`. These official tasks are tasks that I had on my roadmap for new features, if you want to be responsible for any of these tasks, just show your interest commenting on the issue and I'll assign you to it.

Also, any other pull request can be submitted, there's no need to follow a task to send new features to this project, any contribuition is completely appreciated :)

When creating or changing any features, this project has an average of 15-35k visitors daily with peaks of 300-400 simultaneous visitors during the day.

---

The map was built using the following technologies:
- PHP 5.6.21
- Laravel 5.1
- Google Maps API v3
- MySQL 5.7.13
- Memcached/Memcache

---

# Getting Started

1. Create a database named `pgo`.
1. Go to project's root and run `mysql -u[user] -p[pass] pgo < pgo-*.sql`
2. Copy the environment file using `cp .env.dist .env`
3. Edit the `.env` file according to your environment. No need to change keys.
4. `composer install`
5. Check if Memcached/Memcache is running.
6. Have fun.

**IMPORTANT:** Any changes on the JS files must be compiled before testing. I had no time to setup the gulp task, so you can compile the js files by accessing the compile route, just check the `routes.php` file to see what's the compile url to be accessed.