<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

### Public knockout brackets

When a tournament has a knockout phase, its public tournament page displays
the bracket in the **Clasificación** tab, alongside any league standings,
not in the match list. The Live page offers **Cuadro de cruces**
beside **Clasificación**, defaulting to the bracket when standings are empty.
Both pages share the same read-only bracket: rounds, connecting lines, team
names, dates, scores including extra time, penalty winners and a separate
third-place match. Unassigned teams display **Por definir** and empty phases
show that pairings have not yet been generated. On mobile the rounds scroll
horizontally; the Live bracket refreshes with the existing five-second polling.

### Pending league classifications

Both public tournament pages list every league/group phase in phase order,
even when no standings rows exist yet. A league with a configured participant
count displays its remaining places as **Equipo N · por definir**, alongside
any assigned teams. A phase without a participant count shows **Sin equipos
asignados aún** until its standings exist. Pending places have no fabricated
points or results. Phases with identical names remain separate.

### Printable live tournament QR

**Descargar QR**, beside the tournament PDF download on desktop and mobile,
downloads an A4 portrait poster with the school and tournament names, a large
locally generated QR and its readable, clickable URL. The poster includes the
club logo (when configured), school primary-color accents, a high-contrast
headline and three scanning instructions. Logos retain their proportions and
the 19 cm square QR stays black on white with its clear scanning margin.
Compact headers and 8 mm page margins keep the poster on one A4 page. A configured logo
that is missing or invalid produces an explicit error.
The QR targets
`https://{school-domain}/live/{tournament}`, falling back to the school's
`{slug}.vaed.es` subdomain, never the admin panel host.
The poster can be prepared before Live is enabled. Downloading does not change
the tournament: a warning explains when Live is disabled, the tournament is
cancelled or the school is inactive, as the public link is not yet accessible.
Missing or invalid school domains produce an explicit error instead of a QR.

### Automatic tournament match times

The Matches tab offers **Asignar hora automática** on desktop and mobile.
Choose the first match's date and time, one or two parts, duration of each part
and rest in minutes. The same rest applies between parts and between matches:
the interval between starts is `(part duration + rest) * number of parts`.
All listed matches are scheduled sequentially across every phase and round,
using exactly the displayed order. Category-based tournaments affect the
selected category; open tournaments affect all their listed matches.
Existing dates and times are replaced atomically, without changing results or
statuses. Times continue into the next day when they pass midnight.
For example, 09:00 with one 20-minute part and 5-minute rests produces
09:00, 09:25, 09:50, and so on. With two 20-minute parts and the same rests,
the starts are 09:00, 09:50, 10:40, and so on.

### Reusing recent tournament teams

In tournament management, **Add team** offers **Create from scratch** and
**Recent teams**, on desktop and mobile. Recent teams belong to the same club
and to non-cancelled tournaments created between the start of the day one
calendar month ago and now. Their event dates do not affect eligibility:
upcoming tournaments and tournaments without event dates are included.
Teams already registered in the destination category are excluded; repeated
entries use the most recently updated record.

Select multiple recent teams with the checkboxes and use the single
**Add selected** button in the fixed modal footer, outside the scrolling list.
The batch is atomic: if an entry cannot be imported, no selected team is added.
After success, the modal stays open, the selection clears and imported teams
disappear from the available list.

Adding a recent team copies its name, school-team reference where applicable,
contact details, email, existing password hash, seed, notes and an independent
copy of its logo. The group is empty, the status becomes registered and the
registration token is not reused. Players, matches, standings and sanctions
are not copied. School teams become external teams when added to an open
tournament.

Focused regression tests: `php vendor/phpunit/phpunit/phpunit tests/Feature/RecentTournamentTeamsTest.php`.

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
