# lytix\_logs

This plugin is a subplugin of [local_lytix](https://github.com/llttugraz/moodle-local_lytix).
The `lytix_logs` module plays a crucial role in capturing user interactions within the custom-developed dashboard that are not automatically recorded by Moodle. These logs are pivotal in painting a comprehensive picture of user interactions and can be utilized for various purposes, including generating statistics and reports.

## Table of Contents

- [Installation](#installation)
- [Requirements](#requirements)
- [Features](#features)
- [Configuration](#configuration)
- [Usage](#usage)
- [Dependencies](#dependencies)
- [API Documentation](#api-documentation)
- [Subplugins](#subplugins)
- [Privacy](#privacy)
- [FAQ](#faq)
- [Known Issues](#known-issues)
- [Changelog](#changelog)
- [License](#license)
- [Contributors](#contributors)

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

## Configuration

Describe here how to configure the plugin after installation, including available settings and how to adjust them.

## Usage

Explain how to use the plugin with step-by-step instructions and provide screenshots if they help clarify the process.

## Dependencies

- [local_lytix](https://github.com/llttugraz/moodle-local_lytix).
- [lytix_config](https://github.com/llttugraz/moodle-lytix_config).

## API Documentation

If your plugin offers API endpoints, document what they return and how to use them here.

## Subplugins

If there are any subplugins, provide links and descriptions for each.

## Privacy

Detail what personal data the plugin stores and how it handles this data.

## FAQ

**Q:** Frequently asked question here?
**A:** Answer to the question here.

**Q:** Another frequently asked question?
**A:** Answer to the question here.

## Known Issues

- Issue 1: Solution or workaround for the issue.
- Issue 2: Solution or workaround for the issue.

## License

This plugin is licensed under the [GNU GPL v3](https://github.com/llttugraz/moodle-lytix_logs?tab=GPL-3.0-1-ov-file).

## Contributors

- **Günther Moser** - Developer - [GitHub](https://github.com/ghinta)
- **Alex Kremser** - Developer - [GitHub](https://github.com/llt-tuggy)

