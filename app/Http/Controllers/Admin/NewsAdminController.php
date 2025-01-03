<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Session;

use App\Models\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;

class NewsAdminController extends Controller
{
    public function newsCreate()
    {
        return view('admin/newsCreate');
    }

    public function insertNews(Request $request)
    {
        $formData = $request->all();


        $news = new News();
        $news->title = $formData['newsTitle'];
        $news->content = $formData['newsContent'];

        $logoFileName = $formData['logoFileName'];
        $logoFileData = $formData['logoFileData'];

        // Remove the base64 prefix
        $imageData = preg_replace('/^data:image\/(jpeg|png);base64,/', '', $logoFileData);

        // Decode the base64 data
        $decodedImage = base64_decode($imageData);

        $imageName = time() . "_" . $logoFileName;

        // Absolute path to the upload location
        $uploadLocation = public_path('newsBanner'); 

        // // S3 bucket folder
        // $s3BucketFolder = 'southjstimages';

        // // Full path in the S3 bucket
        // $s3FilePath = $s3BucketFolder . '/' . $imageName;

        // // Upload the file to S3
        // $isUploaded = Storage::disk('s3')->put($s3FilePath, $decodedImage);

        // Ensure the directory exists
        if (!file_exists($uploadLocation)) {
            mkdir($uploadLocation, 0755, true);
        }

        // // Full image path
        $imagePath = $uploadLocation . '/' . $imageName;

        // // Save the image
        $isSaved = file_put_contents($imagePath, $decodedImage);

        if ($isSaved) {
            $imageUrl = asset('newsBanner/' . $imageName); // Public URL
            $news->image = $imageUrl; // Save the public path in the database

            // Get the public URL of the file
            // $imageUrl = Storage::disk('s3')->url($s3FilePath);
            // $news->image = $imageUrl;
        } else {
            return response()->json(['error' => 'Failed to save the image'], 500);
        }

        // Handle multiple cropped images
        $croppedImages = json_decode($formData['croppedImagesData'], true); // Decode the JSON data

        $imagePaths = [];
        if (!empty($croppedImages)) {
            foreach ($croppedImages as $image) {
                // Upload each base64 image and store its path
        //         $imageFile = $this->uploadEventLogo($image['data'], $image['name'], $uploadResource);

        //         $imagePaths[] = $imageFile; // Collect each image path in the array

                // Remove the base64 prefix for each cropped image
                $imageData = preg_replace('/^data:image\/(jpeg|png);base64,/', '', $image['data']);
                $decodedImage = base64_decode($imageData);

                // Generate a unique name for each cropped image
                $croppedImageName = time() . "_" . $image['name'];
                $croppedImagePath = $uploadLocation . '/' . $croppedImageName;

                // // Save the cropped image
                $isCroppedSaved = file_put_contents($croppedImagePath, $decodedImage);

                // // S3 bucket folder
                // $s3BucketFolder = 'southjstimages';

                // // Full path in the S3 bucket
                // $s3FilePath = $s3BucketFolder . '/' . $croppedImageName;

                // // Upload the cropped image to S3
                // $isUploaded = Storage::disk('s3')->put($s3FilePath, $decodedImage);

                if ($isCroppedSaved) {
                    // Store the public URL of each cropped image
                    $imagePaths[] = asset('newsBanner/' . $croppedImageName);
                    // $imagePaths[] = Storage::disk('s3')->url($s3FilePath);
                }
            }
        }

        // // Save the images in the database as a JSON array
        $news->otherImages = $imagePaths;

        $news->startDate = (int) $formData['startDate'];
        $news->endDate = (int) $formData['endDate'];
        $news->isDeleted = false;

        $news->save();


        if ($news->save()) {

            $adminId = Session::get('admin_id');
            // ActivityLogHelper::log($adminId, 'News create', "Breaking News: $news->title just in", 'news', $news->_id);

            return response()->json([
                'success' => true,
                'message' => 'News created successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'News creation failed.'
            ]);
        }
    }

    public function allNews()
    {
        $currentDate = (int) Carbon::now()->format('Ymd');
        // $ongoingNews = News::where('startDate', '<=', $currentDate)->where('endDate', '>=', $currentDate)->where('isDeleted', false)->orderBy('created_at', 'desc')->get();
        $ongoingNews = News::where('endDate', '>=', $currentDate)->where('isDeleted', false)->orderBy('created_at', 'desc')->get();
        $archivedNews = News::where('endDate', '<', $currentDate)->where('isDeleted', false)->orderBy('created_at', 'desc')->get();
        return view("admin.allNews", compact('ongoingNews', 'archivedNews'));
    }

    public function deleteNews(Request $request)
    {
        $newsId = $request->input('newsId');

        $adminId = Session::get('admin_id');

        $deleteNews = News::where(['_id' => $newsId])->update(['isDeleted' => true]);

        // ActivityLogHelper::log($adminId, 'News Delete', 'Deleted a News with ID ' . $newsId);

        return response()->json(['status' => 'success', 'message' => 'News deleted successfully.']);
    }

    public function editNews($newsId)
    {
        $newsDetails = News::where('_id', $newsId)->first();
        return view('admin.editNewsView', compact('newsDetails', 'newsId'));
    }

    public function updateNews(Request $request)
    {
        $formData = $request->all();

        // print_r($formData);
        // die;
        $adminId = Session::get('admin_id');

        $newsId = $formData['newsId'];

        $news = News::where('_id', $newsId)->first();
        $news->title = $formData['newsTitle'];
        $news->content = $formData['newsContent'];


        $logoFileName = $formData['logoFileName'];
        $logoFileData = $formData['logoFileData'];

        if (empty($logoFileData)) {
            $imageurl = $news['image'];
            $news->image = $imageurl;
        } else {
            // Remove the base64 prefix
            $imageData = preg_replace('/^data:image\/(jpeg|png);base64,/', '', $logoFileData);

            // Decode the base64 data
            $decodedImage = base64_decode($imageData);

            $imageName = time() . "_" . $logoFileName;

            // Absolute path to the upload location
            $uploadLocation = public_path('newsBanner'); // Resolves to /var/www/html/public/images

            // Ensure the directory exists
            if (!file_exists($uploadLocation)) {
                mkdir($uploadLocation, 0755, true);
            }

            // Full image path
            $imagePath = $uploadLocation . '/' . $imageName;

            // Save the image
            $isSaved = file_put_contents($imagePath, $decodedImage);

            // // S3 bucket folder
            // $s3BucketFolder = 'southjstimages';

            // // Full path in the S3 bucket
            // $s3FilePath = $s3BucketFolder . '/' . $imageName;

            // // Upload the file to S3
            // $isUploaded = Storage::disk('s3')->put($s3FilePath, $decodedImage);

            if ($isSaved) {
                $imageUrl = asset('newsBanner/' . $imageName); // Public URL
                $news->image = $imageUrl; // Save the public path in the database

                // Get the public URL of the file
                // $imageUrl = Storage::disk('s3')->url($s3FilePath);
                // $news->image = $imageUrl;
            } else {
                return response()->json(['error' => 'Failed to save the image'], 500);
            }
        }

        $croppedImages = json_decode($formData['croppedImagesData'], true);

        // Initialize an array to hold the paths of the new images
        $newImagePaths = [];

        // Get the existing images from the database
        $existingImages = $news->otherImages; // Assuming otherImages is a JSON string

        // Process new cropped images
        if (!empty($croppedImages)) {
            foreach ($croppedImages as $image) {

                $imageData = preg_replace('/^data:image\/(jpeg|png);base64,/', '', $image['data']);
                $decodedImage = base64_decode($imageData);
                $uploadLocation = public_path('newsBanner');

                // Generate a unique name for each cropped image
                $croppedImageName = time() . "_" . $image['name'];
                $croppedImagePath = $uploadLocation . '/' . $croppedImageName;

                // Save the cropped image
                $isCroppedSaved = file_put_contents($croppedImagePath, $decodedImage);

                // // S3 bucket folder
                // $s3BucketFolder = 'southjstimages';

                // // Full path in the S3 bucket
                // $s3FilePath = $s3BucketFolder . '/' . $croppedImageName;

                // // Upload the cropped image to S3
                // $isUploaded = Storage::disk('s3')->put($s3FilePath, $decodedImage);

                if ($isCroppedSaved) {
                    // Store the public URL of each cropped image
                    $imagePaths[] = asset('newsBanner/' . $croppedImageName);
                    // $newImagePaths[] = Storage::disk('s3')->url($s3FilePath);
                }
            }
        }

        // Combine existing images with new images
        $allImagePaths = array_merge($existingImages, $newImagePaths);

        // Save the combined images in the database as a JSON array
        $news->otherImages = $allImagePaths; // Ensure to encode it back to JSON

        $news->startDate = (int) $formData['startDate'];
        $news->endDate = (int) $formData['endDate'];
        $news->isDeleted = false;

        $news->save();


        if ($news->save()) {

            // ActivityLogHelper::log($adminId, 'News update', 'Updated a News with ID ' . $newsId);

            return response()->json([
                'success' => true,
                'message' => 'News updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'News updation failed.'
            ]);
        }
    }

    public function newsDetails($newsId)
    {
        $currentDate = (int) Carbon::now()->format('Ymd');

        $news = News::where(['_id' => $newsId])->first();
        $news['content'] = $this->processOembedTags($news['content']);

        return view('admin.newsDetails',  compact('news'));
    }

    private function processOembedTags($content)
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress HTML5 warnings
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $oembedTags = $dom->getElementsByTagName('oembed');

        foreach ($oembedTags as $oembed) {
            $url = $oembed->getAttribute('url');
            
            // Check if it's a YouTube URL and convert to embed format
            if (strpos($url, 'youtu.be') !== false) {
                $videoId = basename($url);  // Get the video ID from the URL
                $url = "https://www.youtube.com/embed/{$videoId}";  // Convert to embed URL
            }

            // Check if it's a Facebook URL and convert to embed format
            if (strpos($url, 'facebook.com') !== false) {
                $encodedUrl = urlencode($url);  // URL encode the Facebook URL
                $url = "https://www.facebook.com/plugins/video.php?href={$encodedUrl}&show_text=0&width=560";  // Facebook embed URL
            }

            // Check if it's a Twitter/X URL and convert to embed format
            if (strpos($url, 'twitter.com') !== false || strpos($url, 'x.com') !== false) {
                // Twitter embeds use a blockquote and require their widget.js
                $tweetEmbed = $dom->createElement('blockquote');
                $tweetEmbed->setAttribute('class', 'twitter-tweet');
                $tweetEmbed->setAttribute('data-lang', 'en');

                $link = $dom->createElement('a', $url); // Create an anchor element pointing to the tweet URL
                $link->setAttribute('href', $url);

                $tweetEmbed->appendChild($link); // Add the link to the blockquote

                // Add Twitter/X's widget.js script to the DOM if not already present
                $scriptTag = $dom->createElement('script');
                $scriptTag->setAttribute('src', 'https://platform.twitter.com/widgets.js');
                $scriptTag->setAttribute('async', 'true');

                $oembed->parentNode->replaceChild($tweetEmbed, $oembed);
                $dom->appendChild($scriptTag); // Ensure the script is added to the DOM
                continue; // Skip the rest of the processing for this URL
            }

            $iframe = $dom->createElement('iframe');
            $iframe->setAttribute('src', $url);
            $iframe->setAttribute('width', '560'); // Set desired width
            $iframe->setAttribute('height', '315'); // Set desired height
            $iframe->setAttribute('frameborder', '0');
            $iframe->setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
            $iframe->setAttribute('allowfullscreen', 'true');

            $oembed->parentNode->replaceChild($iframe, $oembed);
        }

        return $dom->saveHTML();
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('newsBanner', $fileName, 'public'); // Store in public/newsBanner

            // Return the file's URL to CKEditor
            return response()->json([
                'url' => asset('storage/' . $filePath), // URL to access the uploaded image
            ]);
        }

        // If no file is uploaded, return an error
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

}
