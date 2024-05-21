# lytix\_logs

This plugin is a subplugin of [local_lytix](https://github.com/llttugraz/moodle-local_lytix).  
The `lytix_logs` module plays a crucial role in capturing user interactions within the custom-developed dashboard that are not automatically recorded by Moodle. These logs are pivotal in painting a comprehensive picture of user interactions and can be utilized for various purposes, including generating statistics and reports.

## Installation

1. Download the plugin and extract the files.
2. Move the extracted folder to your `moodle/local/lytix/modules` directory.
3. Log in as an admin in Moodle and navigate to `Site Administration > Plugins > Install plugins`.
4. Follow the on-screen instructions to complete the installation.

## Requirements

- Moodle Version: 4.1+
- PHP Version: 7.4+
- Supported Databases: MariaDB, PostgreSQL
- Supported Moodle Themes: Boost

## Features

- Captures specific interactions within the self-developed dashboard that are not inherently recorded by Moodle.
- The recorded data is stored in the backend using PHP and can be accessed for further analysis.
- Incorporates an essential database table:
  - `lytix logs logs`: Records actions associated with the custom dashboard.

## Dependencies

- [local_lytix](https://github.com/llttugraz/moodle-local_lytix).
- [lytix_config](https://github.com/llttugraz/moodle-lytix_config).

## License

This plugin is licensed under the [GNU GPL v3](https://github.com/llttugraz/moodle-lytix_logs?tab=GPL-3.0-1-ov-file).

## Contributors

- **Günther Moser** - Developer - [GitHub](https://github.com/ghinta)
- **Alex Kremser** - Developer
