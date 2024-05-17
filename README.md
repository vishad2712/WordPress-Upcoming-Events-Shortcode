# Upcoming Events Shortcode

A custom WordPress function to display upcoming events with event date, time and location. 

## Description

This WordPress function provides a shortcode `[upcoming_events]` that can be used to display a list of upcoming events on any page or post. Events are retrieved from the custom post type "Event" and filtered based on their event date.

## Create Custom Fields with ACF

1. **Event Date**: Create a date picker field named `event_date`.
2. **Event Time**: Create a time picker field named `event_time`.
3. **Event Location**: Create a text field named `event_location`.

## Features

- Displays upcoming events with event date, time and location.
- Supports custom post type "Event".
- Automatically filters out past events.
- Customizable number of events displayed per page.
- Responsive layout using Bootstrap grid system.

## Usage

To display upcoming events on a page or post, copy and paste the provided function into your theme's `functions.php` file. Then, use the `[upcoming_events]` shortcode in any page or post content where you want to display the events.

By default, it will display 6 upcoming events. You can customize the number of events displayed by modifying the `posts_per_page` attribute in the shortcode within the function.

Example usage:

```php
[upcoming_events posts_per_page="8"]
