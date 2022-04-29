# IMDMedia project links
## trello link
https://trello.com/b/cFvYkC5C/php-team-14

## miro link
https://miro.com/app/board/uXjVOEMUSEc=/?invite_link_id=920150867488

## figma links
### figma link mobile
https://www.figma.com/file/wEY5xEHndt1DHR6y2Wouzo/Untitled?node-id=1%3A2
### figma link desktop
https://www.figma.com/file/3jLkKW1NIWjDDEwijXVlkG/Untitled

## opdracht link
https://docs.google.com/document/d/1QhlzCRcnYmopg5OyNkhBeSsuQZvTCPn9BBs5iB1dwAQ/edit#

# command's project
## mac OS users 
(Voer deze comando's uit in je Mac Terminal, let op ik bedoel niet de terminal van VS Code)

/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
(dit is homebrew, een package manager voor mac. je zal dit nodig hebben om sass te instaleren)


brew install sass/sass/sass
(eenmaal homebrew geinstalleerd is gebruik je deze command om sass te insteleren)

## sass
npm install -g sass (dit werkt enkel op windows)


sass ./sass/app.scss ./css/app.css --watch (live wijzigingen bekijken)


## Uploaden naar cloudinary
(stap 1)

(input veldje maken voor files in up te kunne loaden)
<input type="file" name="file">

(stap 2)

(files meegeven in POST en dan binden aan een var)
$file = $_FILES['file'];


(stap 3)


(maak een nieuwe instantie van de klasse waar je files je files aan bind)
$post = new Post();
$post->setFile($file);


(stap 4)
(zet de volgende code bovenaan in de klasse waarmee je een fileupload wilt doen)
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

Configuration::instance([
        'cloud' => [
          'cloud_name' => 'dzhrxvqre',
          'api_key' => '387513213267173',
          'api_secret' => '1lBrjQy2GXP39NT1pwnvD1SxyKo'],
        'url' => [
          'secure' => true]]);


(stap 5)

(voeg deze functie toe om je file te uploaden)
  public function upload()
        {
            
            

            $file = $this->file;
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
   
  
            if ($fileError === 0) {
                if ($fileSize < 1000000) {

                            //uploads file to cloudinary
                    $cloudinary = (new uploadApi())->upload(
                        $fileTmpName,
                        [
                                            (Verander hier de 'Posts/' naar de folder naar waar je wilt uploaden, vraag aan mijn wat de naam van de folder is of als je wilt dat ik een nieuwe folder aanmaak.)(voorbeeld: je wilt naar een folder for profile pictures uploaden, dan verander je 'Posts/' naar 'profile_pictures/')
                                'folder' => 'Posts/',
                                "format" => "webp",
                                ]
                    );


                    (vergeet niet een plaats te voorzien in je klassen en database om de url van je file op te slaan)
                    //stores the new url in the class
                    $this->setFilePath($cloudinary['url']);
                } else {
                    throw new Exception("Your file is too big!");
                }
            } else {
                throw new Exception("There was an error uploading your file!");
            }
        }