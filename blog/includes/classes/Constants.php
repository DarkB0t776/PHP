<?php

class Constants
{
    public static $categoryNameType = 'Category name can only consist of A-Z,a-z';
    public static $categoryNameLength = "Category name should not be less than 3 or greater than 30 characters";
    public static $categoryExists = "Category already exists";
    public static $categoryCreated = "Category created successfully";

    public static $postTitleType = "Post title can only consist of A-Z, a-z and 0-9";
    public static $postTitleLength = "Post title should not be less than 5 or greater than 200 characters";
    public static $postTitleExists = "Post title already exists";
    public static $postDescriptionLength = "Post description should not be less than 20 or greater than 255 characters";

    public static $imageType = "Image format can only be JPG, JPEG or PNG";

    public static $fullNameType = "Full name can only consist of A-Z,a-z";
    public static $fullNameLength = "Full name should not be less than 2 or greater than 100 characters";

    public static $usernameType = "Username can only consist of A-Z,a-z and 0-9";
    public static $usernameLength = "Username should not be less than 4 or greater than 30 characters";
    public static $usernameExists = "Username already exists";

    public static $emailInvalid = "Email is invalid";
    public static $emailLength = "Email should not be greater than 100 characters";
    public static $emailExists = "Email already exists";

    public static $roleNameType = 'Role name can only consist of A-Z,a-z';
    public static $roleNameLength = "Role name should not be less than 3 or greater than 50 characters";
    public static $roleExists = "Role already exists";
}
