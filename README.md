# Coolness Plugin for WordPress

**Plugin Name:** Coolness  
**Description:** A simple plugin to track and display post views on WordPress posts. It increments the view count each time a user visits a single post and displays the view count at the bottom of the post. Additionally, it provides a shortcode to display a list of the top viewed posts.  
**Version:** 1.2  
**Author:** Ijan van der Westhuizen  
**License:** Unlicensed

---

## Features

- **Post View Tracking:** Automatically increments the view count for each post every time it is visited.
- **Display View Count:** Shows the view count on the post page, with dynamic pluralization (e.g., "1 view" or "5 views").
- **Top Viewed Posts:** Displays a list of the top 10 most-viewed posts using the `[top_posts]` shortcode.
- **Default Views:** Automatically sets the view count to 0 for new posts.

---

## Installation

1. Download the plugin and extract the contents of the zip file.
2. Upload the extracted folder to the `/wp-content/plugins/` directory of your WordPress installation.
3. In your WordPress admin dashboard, go to **Plugins** > **Installed Plugins**.
4. Find **Coolness** in the list and click **Activate**.

---

## Usage

- **Display View Count on Posts:**  
Once activated, the plugin automatically adds the view count to the bottom of every single post page.

- **Top Viewed Posts Shortcode:**  
To display a list of the top 10 most viewed posts, use the following shortcode anywhere in your posts or pages:
[top_posts]
This will render a list of the 10 most viewed posts, showing their titles and view counts.

---

## Functions

- **coolness_new_view:**  
Increments the view count for each single post visit.

- **coolness_views:**  
Fetches the view count for the current post and returns a message indicating the number of views.

- **coolness_display_views:**  
Appends the view count to the content of the post when displayed on the frontend.

- **coolness_set_default_views:**  
Sets the default view count to 0 for new posts.

- **coolness_list:**  
Fetches the top viewed posts and displays them in descending order.

---

## Changelog

### Version 1.2
- Added support for top viewed posts display via `[top_posts]` shortcode.
- Ensured view count defaults to 0 for newly created posts.

---

## License

This plugin is **unlicensed**. Feel free to use, modify, and distribute it according to your needs.
