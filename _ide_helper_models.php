<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $link_id
 * @property int|null $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Link $link
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClickLog whereUserId($value)
 */
	class ClickLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $url
 * @property string|null $icon
 * @property string|null $bg_color
 * @property string|null $text_color
 * @property int $order
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClickLog> $clickLogs
 * @property-read int|null $click_logs_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereBgColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUserId($value)
 */
	class Link extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $custom_css
 * @property string|null $custom_js
 * @property int $is_public
 * @property string|null $page_password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCustomCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCustomJs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting wherePagePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUserId($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $platform
 * @property string $handle
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile whereHandle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProfile whereUserId($value)
 */
	class SocialProfile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $background_color
 * @property string $text_color
 * @property string $button_style
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Theme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme query()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereButtonStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereUpdatedAt($value)
 */
	class Theme extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $theme_id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string|null $bio
 * @property string|null $avatar
 * @property string $role
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClickLog> $clickLogs
 * @property-read int|null $click_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Setting|null $setting
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialProfile> $socialProfiles
 * @property-read int|null $social_profiles_count
 * @property-read \App\Models\Theme|null $theme
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereThemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

