/*
use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Illuminate\Support\Facades\Request;

class Activity extends SpatieActivity
{
    protected static function booted()
    {
        static::creating(function (Activity $activity) {
            $activity->ip_address = Request::ip();
            $activity->user_agent = Request::userAgent();
        });
    }
}
*/
