import Skeleton from "react-loading-skeleton";
import "react-loading-skeleton/dist/skeleton.css";

export default function ProductSkeletonCard() {
  return (
    <div className="w-[250px] border rounded p-2 shadow space-y-2">
      <Skeleton height={250} />
      <Skeleton height={20} width="80%" />
      <Skeleton height={15} width="60%" />
      <div className="pt-2">
        <Skeleton height={30} width="100%" />
      </div>
    </div>
  );
}
