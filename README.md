# lytix_logs

## Overview
The `lytix_logs` module plays a crucial role in capturing user interactions within the custom-developed dashboard that are not automatically recorded by Moodle. These logs are pivotal in painting a comprehensive picture of user interactions and can be utilized for various purposes, including generating statistics and reports.

## Features

### Custom Dashboard Interactions
- Captures specific interactions within the self-developed dashboard that are not inherently recorded by Moodle.
- The recorded data is stored in the backend using PHP and can be accessed for further analysis.

### Database Tables
- Incorporates two essential database tables:
    - `lytix logs logs`: Records actions associated with the custom dashboard.

## Usage
1. Install and activate the `lytix_logs` module in your Moodle instance.
2. Interactions within the custom dashboard will be automatically recorded.
3. Use the provided functions and interfaces to retrieve and analyze the recorded data.

> **Note**: Ensure you have the required permissions to install, activate, and access the logs in Database.
> 