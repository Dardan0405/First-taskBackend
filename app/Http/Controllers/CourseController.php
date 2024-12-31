<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Thread;
class CourseController extends Controller
{
    
    public function create(Request $request)
    {
        try {
            // Extract the token from the Authorization header
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Authorization header missing'], 401);
            }

            $token = str_replace('Bearer ', '', $authHeader);

            // Check if the token starts with the prefix '1'
            if (!str_starts_with($token, '1')) {
                return response()->json(['error' => 'Unauthorized: Only instructors can create courses'], 403);
            }

            // Remove the prefix before decoding the token
            $strippedToken = substr($token, 1);
            JWTAuth::setToken($strippedToken);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Validate the request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            // Create the course
            $course = Course::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'instructor_id' => $user->id ?? null, // Assign instructor ID if available
               
            ]);

            return response()->json(['message' => 'Course created successfully!', 'course' => $course], 201);

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is missing'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()], 500);
        }
    }
    public function enroll(Request $request)
    {
        try {
            // Extract the token from the Authorization header
            $authHeader = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $authHeader);

            // Check if the token starts with `2`
            if (!str_starts_with($token, '2')) {
                return response()->json(['error' => 'Unauthorized: Only users can enroll in courses'], 403);
            }

            // Remove the prefix before decoding the token
            $strippedToken = substr($token, 1);
            JWTAuth::setToken($strippedToken);
            $user = JWTAuth::authenticate();

            // Validate the request
            $validatedData = $request->validate([
                'course_title' => 'required|string|exists:courses,title',
            ]);

            // Find the course by title
            $course = Course::where('title', $validatedData['course_title'])->first();

            // Enroll the user in the course
            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);

            return response()->json(['message' => 'Enrolled successfully!'], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function delete(Request $request)
    {
        try {
            // Extract the token from the Authorization header
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Authorization header missing'], 401);
            }
    
            $token = str_replace('Bearer ', '', $authHeader);
    
            // Check if the token starts with `4`
            if (!str_starts_with($token, '4')) {
                return response()->json(['error' => 'Unauthorized: Only admin tokens can delete courses'], 403);
            }
    
            // Remove the prefix before decoding the token
            $strippedToken = substr($token, 1);
    
            // Authenticate the user using the stripped token
            JWTAuth::setToken($strippedToken);
            $user = JWTAuth::authenticate();
    
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
    
            // Validate the request
            $validatedData = $request->validate([
                'course_id' => 'required|integer|exists:courses,id',
            ]);
    
            // Find the course by ID
            $course = Course::find($validatedData['course_id']);
    
            if (!$course) {
                return response()->json(['error' => 'Course not found'], 404);
            }
    
            // Delete the course
            $course->delete();
    
            return response()->json(['message' => 'Course deleted successfully!'], 200);
    
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is missing'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()], 500);
        }
    }
    



    
}
