This plugin can make your life easier by grabbing an image URL out of a string. This is particularly useful for automatically generating feed thumbnails when combined with something that can manipulate images like [CE Image](http://devot-ee.com/add-ons/ce-image).


    {if '{exp:extract_image_url}{blog_body}{/exp:extract_image_url}' != ''}
        <p>image found: {exp:extract_image_url}{blog_body}{/exp:extract_image_url}</p>
    {/if}