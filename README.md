#Gocodes

ExpressionEngine 3 Plugin for switching out shortcodes in templates and entries for contents of other templates.

##Usage: 

1. Be certain have enabled "Save templates as files" in the template manager.<br>
Create a template group to hold templates you'll want to call with shortcodes in system/user/templates/default_site 	
2. Create the templates you'll want to switch out.<br>
Note: EE template tags will not render.
3. Add shortcodes in the format [template_name] in templates or channel entries. When the page renders the shortcode will be replaced with the content of shortcodes/template_name

##Tag Pairs

###{exp:gocodes:templates}

Returns searches tagdata for shortcodes. If a template is available, the shortcode will be replaced with the content of the template.

| Parameter | Required? |	Description | Default | Options
| --- | --- | --- | --- | --- |
|	template_group | No | The name of the shortcodes templates group | shortcodes	| |
|	template_type | No | File type of the template the shortcode will be replaced with | html	| html, feed, css, js, xml|

###Example

In this example we want to let the website editor add a newsletter signup form to blog posts entries by dropping in the shortcode [newsletter_signup_form]

Once there's a newsletter signup form named newsletter_signup_form in the shortcodes template group, we wrap the custom field for the post copy in the {exp:gocodes:templates} tag pair. 

When the blog post renders, [newsletter_signup_form] is replaced with the contents of the shortcodes/newsletter_signup_form template.

```
{exp:channel:entries
	channel="blog"
	limit="1"
}
	<h1>{title}</h1>
	{exp:gocodes:templates
		template_group="shortcodes"
		template_type="html"}
		{channel_custom_field}
	{/exp:gocodes:templates}
{/exp:channel:entries}
```
