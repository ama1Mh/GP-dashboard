import sys
import json
from inference import InferenceHTTPClient

def analyze_image(image_path):
    # Initialize the client
    CLIENT = InferenceHTTPClient(
        api_url="https://serverless.roboflow.com",
        api_key="7mKBrs45nrqlWE2RLCl7"
    )

    # Infer on the image
    result = CLIENT.infer(image_path, model_id="gpmodel/1")
    return result

if __name__ == "__main__":
    image_path = sys.argv[1]
    result = analyze_image(image_path)
    print(json.dumps(result))